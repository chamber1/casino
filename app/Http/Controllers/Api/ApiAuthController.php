<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use SMSRU;
use App\Models\ClientRegisterAttempt;
use App\Models\Client;


class ApiAuthController extends Controller{
    
    
    protected $guard = 'api';
    
    
    /**
     * Access point to User who trying to register.
     *
     * @return 
     */
    public function getCode(Request $request) {
        
        $phone_number = $request->get('phone_number');
        //$phone_number = $this->formatPhoneNumber($phone_number);
        $code =  mt_rand(1000,9999);
    
        
        $registerAttempt = ClientRegisterAttempt::where('phone_number', '=', $phone_number)->get()->toArray();
        
        if(count($registerAttempt) == 3){ 
     
            return response()->json(['error' => 'Was 3 attepmts to register'], 401);
            
        }
            
        if(1 /*$this->sendCode($phone_number, $code)*/){
            
            
            $hash = Hash::make($phone_number.$code);
            
            ClientRegisterAttempt::create([
                'phone_number' => $phone_number,
                'code' => $code,
                'operation_hash' => $hash,
                'confirmed' => 0
            ]);

            $client = Client::where('phone', '=', $phone_number)->get();
            $client_status = 'new';

            if(count($client)){
               $client_status = 'registered';
            }

            return response()->json([
                'message' => 'Secret code Sended',
                'client_status' => $client_status,
                'hash' => $hash    
            ]);
        }   
       
    }
   
    
    public function checkCode(Request $request){
        
        //$phone_number = $request->get('phone_number');
        $operation_hash  = $request->get('operation_hash');
        //$phone_number = $this->formatPhoneNumber($phone_number);
        $code =  $request->get('code');
        $registerAttempt = ClientRegisterAttempt::
                where('operation_hash', '=', $operation_hash)->
                where('code', '=', $code)
                ->first();
        
       
        

        if(isset($registerAttempt->id) ){
         
       
            $registerAttempt->confirmed = 1;
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $newhash = substr(str_shuffle($permitted_chars), 0, 20);
            $registerAttempt->operation_hash = $newhash;
            
            //dd($newhash);
            $registerAttempt->save();
                    
            return response()->json([
                'message' => 'Code is checked',
                'operation_hash'=> $newhash,
            ]);
            
        
            
        }else{
            

            return response()->json(['error' => 'Secret code wrong'], 401);
        }
        
        
    }
    
    
    
    public function register(Request $request) {
        
        $phone_number = $request->get('phone_number');
        $phone_number = $this->formatPhoneNumber($phone_number);
        $operation_hash  = $request->get('operation_hash');
        $user_name = $request->get('name');
        $password = $request->get('password');
        
        $registerAttempt = ClientRegisterAttempt::
                where('operation_hash', '=', $operation_hash)->first();
        
        //dd($registerAttempt);
     
        if(isset($registerAttempt->id) ){
            
               
                if($registerAttempt->confirmed == 1){
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
