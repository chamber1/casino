<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiRegisterForm;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use SMSRU;
use App\Models\UserRegisterAttempt;
use App\User;


class ApiAuthController extends Controller{
    
    
    
    /**
     * Send SMS Code to User who trying to register.
     *
     * @return 
     */
    public function getcode(Request $request) {
        
        $phone_number = $request->get('phone_number');
        $code =  mt_rand(1111,9999);
    
        
        $registerAttempt = UserRegisterAttempt::where('phone_number', '=', $phone_number)->get()->toArray();
        
        if(count($registerAttempt)==3){ 
     
            return response()->json(['error' => 'Was 3 attepmts to register'], 401);
            
        }else{
            
            $this->sendCode($phone_number, $code);   
            
        }
    }
    
    public function register(Request $request) {
        
        $phone_number = $request->get('phone_number');
        $user_name = $request->get('name');
        $user_password = $request->get('password');
        $code =  $request->get('code');
        
        $registerAttempt = UserRegisterAttempt::where('phone_number', '=', $phone_number)->where('code', '=', $code)->get()->toArray();
        
        if(isset($registerAttempt[0]) && isset($registerAttempt[0]['code'])){
           
            $user = new User();
            $user->name = $user_name;
            $user->phone = $phone_number;
            //$user->email = $user_email;
            $user->password = Hash::make($user_password);
       
            $user->save();
            
        }else{
            
            return response()->json(['error' => 'Secret code wrong'], 401);
            
        }
        
    }
    
    
    
    public function sendCode($phone_number,$code) {
        
        $smsru = new SMSRU(env('SMSRU_KEY'));
        $data = new \stdClass();
        $data->to = $phone_number;
        $data->text = 'Your code is : '.$code;

        $sms = $smsru->send_one($data);

        if ($sms->status == "OK") { 
         
            //echo "Сообщение отправлено успешно. ";
            //echo "ID сообщения: $sms->sms_id. ";
          
            UserRegisterAttempt::create([
                
                'phone_number' => $phone_number,
                'code' => $code,
            ]);
           
            
            
        } else {
            echo "Сообщение не отправлено. ";
            echo "Код ошибки: $sms->status_code. ";
            echo "Текст ошибки: $sms->status_text.";
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
        
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    
    
    
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    
    
}
