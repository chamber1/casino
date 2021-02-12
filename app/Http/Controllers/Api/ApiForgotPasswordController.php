<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ForgotPassword;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


/**
 * Handles Client API Forgot password
 *
 * @author Yuriy Yurenko <yurenkoyura@gmail.com>
 */
class ApiForgotPasswordController extends Controller
{
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
     * Access point to Client who forget password.
     * Generate 4 digits code and send via SMS
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getCode(Request $request) {
        
        $phone_number = $request->get('phone');
        $phone_number = $this->formatPhoneNumber($phone_number);
       
         //check is client with phone number registered
        if($this->checkClientRegistered($phone_number)){
            
            $forgotPassAttempt = ForgotPassword::where('phone_number', '=', $phone_number)->first();
            if(!isset($forgotPassAttempt->id)){
                
                $code =  mt_rand(1000,9999);
                //$this->sendCode($phone_number, $code)*
                ForgotPassword::create([
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
                if($forgotPassAttempt->attempts == $this->allowed_attempts_count){
                    
                    return response()->json([
                        'error' => $this->allowed_attempts_count.'  allowed attempts count expired',
                    ],400);
                }
                
                $curdate = date("Y-m-d H:i:s");
                $datetime1 = date_create($curdate);
                $interval = date_diff($datetime1,$forgotPassAttempt->updated_at);
                $difference = $interval->format("%i") ; //if zero then interval less than 1 minute
                
                //check interval of sending 1 minute
                if($difference >= $this->allowed_sms_interval){
                    
                    $code =  mt_rand(1000,9999);
                    $current_attempts = $forgotPassAttempt->attempts;
                    $new_attempt = $current_attempts+1;
                    
                    $forgotPassAttempt->code = $code;
                    $forgotPassAttempt->attempts = $new_attempt;
                    $forgotPassAttempt->status = 'new';
                    $forgotPassAttempt->save();
                    
                    return response()->json([
                        'message' => 'Code sended',
                        'attempt' => $new_attempt,
                        'code' => $code,
                    ]);
                    
                }else{
                    
                    return response()->json([
                        'message' => 'Resending code will be after '.$this->allowed_sms_interval.' minute(s)',
                    ],202);
                }
            }
            
        }else{
            
            return response()->json([
                  'message' => 'Client not registered',
                ],401);
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
        
        $forgotPassAttempt = ForgotPassword::where('phone_number', '=', $phone_number)->first();
        
        if(isset($forgotPassAttempt->id) ){
                
            if($forgotPassAttempt->status == 'failed' || $forgotPassAttempt->attempts == 3){
                
                return response()->json([
                    'error' => 'Secret code Failed',
                ],401);
            }
           
            if($forgotPassAttempt->code == $code){
                
                $forgotPassAttempt->status = 'checked';
                $forgotPassAttempt->save();
                
                return response()->json([
                    'message' => 'Code is checked',
                    'success' => true
                ],200);
                
            }else{
                
                $forgotPassAttempt->status = 'failed';
                $forgotPassAttempt->save();
                
                return response()->json([
                    'error' => 'Secret code wrong',
                    'success' => false,
                ],402);
            }
        }
    }
    
    /**
     * Change client password
     *
     * @param Request $request 
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function newPassword(Request $request){
        
        $phone_number = $request->get('phone');
        $phone_number = $this->formatPhoneNumber($phone_number);
        $forgotPassAttempt = ForgotPassword::where('phone_number', '=', $phone_number)->first();
        
        if(isset($forgotPassAttempt->id) ){
                
            if($forgotPassAttempt->status == 'failed' || $forgotPassAttempt->attempts == 3){
                
                return response()->json([
                    'error' => 'Secret code Failed',
                ],401);
            }
         
            if($forgotPassAttempt->status = 'checked'){
                
                $new_password = $request->get('password');
                $client = Client::where('phone', '=', $phone_number)->first();
        
                    if(isset($client->id)){

                       $client->password = $new_password;
                       if($client->save()){
                           
                            return response()->json([
                                'message' => 'Password changed succesfully',
                                'success' => true
                            ],200);
                       }
                    }
            }
        }
        
        
        
        
        
        
    }
    
    /**
     * Checks is Client already registered
     * by phone number
     *
     * @param string $phone_number 
     * 
     * @return boolean
     */
    public function checkClientRegistered($phone_number){
        
        $client = Client::where('phone', '=', $phone_number)->first();

        return isset($client->id) ? true : false;
    }
    
    public function formatPhoneNumber($phone_number){
        
        $pos = strpos($phone_number,'+');
        $formatted_number = '';
        if ($pos === false) {
            
            $formatted_number = '+'.$phone_number; 
            return $formatted_number;
        } 
        else{
            
            return $phone_number;
        }
    }
}
