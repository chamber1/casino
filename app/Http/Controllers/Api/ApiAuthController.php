<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiRegisterForm;
use Illuminate\Support\Facades\Config;
use SMSRU;
use App\Models\UserRegisterAttempt;


class ApiAuthController extends Controller{
    
    
    
    /**
     * Send SMS Code to User who trying to register.
     *
     * @return 
     */
    public function register(Request $request) {
        
        $phone_number = $request->get('phone_number');
        $code =  mt_rand(1111,9999);
        $key = env('SMSRU_KEY');
        
        $registerAttempt = UserRegisterAttempt::where('phone_number', '=', $phone_number)->get()->toArray();
        
        
        
        if($registerAttempt){ 
     
        
            
        }else{
            
            UserRegisterAttempt::create([
                
                'phone_number' => $phone_number,
                'code' => $code,
                'attempt_count' => 1
                
            ]);
            
        }
       // $this->sendCode($phone_number, $code);
        
        
    }
    
    
    public function sendCode($phone_number,$code) {
        
        $smsru = new SMSRU($key);
        $data = new \stdClass();
        $data->to = $phone_number;
        $data->text = 'Your code is : '.$code;

        $sms = $smsru->send_one($data);

        if ($sms->status == "OK") { 
         
            //echo "Сообщение отправлено успешно. ";
            //echo "ID сообщения: $sms->sms_id. ";
          
    
           
            
            
        } else {
            echo "Сообщение не отправлено. ";
            echo "Код ошибки: $sms->status_code. ";
            echo "Текст ошибки: $sms->status_text.";
        }
        
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
