<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiRegisterForm;
use Illuminate\Support\Facades\Config;
use SMSRU;

class ApiAuthController extends Controller{
    
    
    
    
    public function register(Request $request) {
        
        $phone_number = $request->get('phone_number');
        $code =  mt_rand(1111,9999);
        $key = env('SMSRU_KEY');
        $smsru = new SMSRU($key);
        $data = new \stdClass();
        $data->to = $phone_number;
        $data->text = 'Your code is : '.$code;

        $sms = $smsru->send_one($data);

        if ($sms->status == "OK") { 
            echo "Сообщение отправлено успешно. ";
            echo "ID сообщения: $sms->sms_id. ";
          
        } else {
            echo "Сообщение не отправлено. ";
            echo "Код ошибки: $sms->status_code. ";
            echo "Текст ошибки: $sms->status_text.";
        }
        
    }
    
    
}
