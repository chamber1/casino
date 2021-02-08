<?php
namespace App\Http\Controllers\Api;

use SMSRU;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\ClientRegister;

/**
 * Handles Client API Authorization
 *
 * @author Yuriy Yurenko <yurenkoyura@gmail.com>
 */
class ApiAuthController extends Controller{
    
    /**
    * Middleware guard
    *
    * @var string
    */
    protected $guard = 'api';
    
    /**
    * Allowed register attempts count for client 
    *
    * @var integer
    */
    public $allowed_attempts_count = 3;
    
    /**
    * Interval between SMS in minutes
    *
    * @var integer
    */
    public $allowed_sms_interval = 0;
    /**
     * Access point to Client who trying to register.
     * Generate 4 digits code and send via SMS
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getCode(Request $request) {
        
        $phone_number = $request->get('phone');
        $phone_number = $this->formatPhoneNumber($phone_number);
        
        $this->sendCodeSMS16($request->get('phone'),'Cool');
        
        //check is client with phone number not registered
        if(!$this->checkClientRegistered($phone_number)){
            
            $registerAttempt = ClientRegister::where('phone_number', '=', $phone_number)->first();
            
            //if client not attemp to register
            if(!isset($registerAttempt->id)){
                
                $code =  mt_rand(1000,9999);
                //$this->sendCode($phone_number, $code)*
                ClientRegister::create([
                    'phone_number' => $phone_number,
                    'code' => $code,
                    'attempts' => 1,
                    'status' => 'new'
                ]);    
                
                return response()->json([
                    'message' => 'Code sended',
                    'attempt' => 1,
                    'code' => $code,
                ]);
                
            }else{
                //if clients attemp to register check attempts
                if($registerAttempt->attempts == $this->allowed_attempts_count){
                    
                    return response()->json([
                        'error' => $this->allowed_attempts_count.'  allowed attempts count expired',
                    ],400);
                }
                
                $curdate = date("Y-m-d H:i:s");
                $datetime1 = date_create($curdate);
                $interval = date_diff($datetime1,$registerAttempt->updated_at);
                $difference = $interval->format("%i") ; //if zero then interval less than 1 minute
                
                //check interval of sending 1 minute
                if($difference >= $this->allowed_sms_interval){
                    
                    $code =  mt_rand(1000,9999);
                    $current_attempts = $registerAttempt->attempts;
                    $new_attempt = $current_attempts+1;
                    
                    $registerAttempt->code = $code;
                    $registerAttempt->attempts = $new_attempt;
                    $registerAttempt->status = 'new';
                    $registerAttempt->save();
                    
                    return response()->json([
                        'message' => 'Code sended',
                        'attempt' => $new_attempt,
                        'code' => $code,
                    ]);
                    
                }else{
                    
                    return response()->json([
                        'message' => 'Resending code will be after '.$this->allowed_sms_interval.' minute(s)',
                    ]);
                }
            }
        }
    }   
    
    
    /**
     * Checks is Client already registered
     * by code and phone number
     *
     * @param string $$phone_number 
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function checkClientRegistered($phone_number){
        
        $client = Client::where('phone', '=', $phone_number)->get();

        if(isset($client[0]->id)){
           return true;
        }else{
            return false;
        }       
    }
    
    /**
     * Checks 4 digits code sended via SMS
     * by code and phone number
     *
     * @param Request $request 
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function checkCode(Request $request){
        
        $phone_number = $request->get('phone');
        $phone_number = $this->formatPhoneNumber($phone_number);
        $code =  $request->get('code');
        
        $registerAttempt = ClientRegister::where('phone_number', '=', $phone_number)->first();
        
        if(isset($registerAttempt->id) ){
                
            if($registerAttempt->status == 'failed'){
                
                return response()->json([
                    'error' => 'Secret code Failed',
                ],400);
            }
            
            if($registerAttempt->code == $code){
                
                $registerAttempt->status = 'checked';
                $registerAttempt->save();
                
                return response()->json([
                    'message' => 'Code is checked',
                ]);
                
            }else{
                
                $registerAttempt->status = 'failed';
                $registerAttempt->save();
                
                return response()->json([
                    'error' => 'Secret code wrong',
                ],400);
            }
        }else{
            
            return response()->json(['error' => 'Not found registration record for this phone number'], 400);
        }
    }
    
    /**
     * Perform client registration
     * by code and phone number
     *
     * @param Request $request 
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        
        $phone_number = $request->get('phone');
        $phone_number = $this->formatPhoneNumber($phone_number);
        $user_name = $request->get('name');
        $password = $request->get('password');
        
        $registerAttempt = ClientRegister::where('phone_number', '=', $phone_number)->first();
        
        if(isset($registerAttempt->id)){
            
            if($registerAttempt->status == 'checked'){
                
                $client = new Client();
                $client->name = $user_name;
                $client->phone = $phone_number;
                $client->password = Hash::make($password);

                if($client->save()){

                    return response()->json([
                        'message' => 'Client registered',
                        'client_id' => $client->id,
                    ]);

                }else{

                    return response()->json(['error' => 'Client not registered'], 400);
                }
            }
        }  
    }

    /**
     * Send SMS Via SMS.ru to phone number with secret code.
     * 
     * @param string $phone_number
     * @param integer $code
     * 
     * @return boolean
     */
    public function sendCode($phone_number,$code) {
        
        $smsru = new SMSRU(env('SMSRU_KEY'));
        $data = new \stdClass();
        $data->to = $phone_number;
        $data->text = 'Your code is : '.$code;

        $sms = $smsru->send_one($data);

        if ($sms->status == "OK") { 
            
            return true;
            
        } else {
            
            return false;
        }
    }
    
     /**
     * Send SMS Via SMS16.ru to phone number with secret code.
     * 
     * @param string $phone_number
     * @param integer $code
     * 
     * @return boolean
     */
    public function sendCodeSMS16($phone_number,$code) {

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://new.sms16.ru/get/timestamp.php');
        $timestamp = $response->getBody()->read(10);
        
        $params = array(
            'timestamp' => $timestamp,
            'login'     => env('SMS_LOGIN'),
            'phone'     => $phone_number,
            'text'      => $code
        );

        ksort($params);
        reset($params);
        
        $api_key = env('SMS_API_KEY');
        $pre_sign = implode($params);
        $sign = $pre_sign.$api_key;
        $signature =  md5($sign);
        $request_url = 'https://new.sms16.ru/get/send.php?'
            . 'login='.env('SMS_LOGIN')
            . '&signature='.$signature
            . '&phone='.$phone_number
            . '&text='.$code
            . '&sender=SOBRANIE'
            . '&timestamp='.$timestamp 
            . '&return=json';
        //dd($request_url);
        $response = $client->request('GET',$request_url);

        echo $response->getBody();
        die("not cool");

    }
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['phone', 'password']);
        
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    
    public function formatPhoneNumber($phone_number){
        
        $pos = strpos($phone_number,'+');
        if ($pos === false) {
            
            return '+'.$phone_number;
        } 
        else{
            
            return $phone_number;
        }
    }
    
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
               
            
