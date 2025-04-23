<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{

    public function sendSms($phone, $message)
    {
        $config = [
            'login' => 'Boron01',
            'hash' => '612ca00d2111f62e1fd110c8c41071c6',
            'sender' => 'Boron.tj',
            'server' => 'https://api.osonsms.com/sendsms_v1.php',
        ];

        $dlm = ";";
        $phone_number = $phone;
        $message = $message;
        $txn_id = uniqid();
        $str_hash = hash('sha256', $txn_id . $dlm . $config['login'] . $dlm . $config['sender'] . $dlm . $phone_number . $dlm . $config['hash']);

        $params = [
            "from" => $config['sender'],
            "phone_number" => $phone_number,
            "msg" => $message,
            "str_hash" => $str_hash,
            "txn_id" => $txn_id,
            "login" => $config['login'],
        ];

        $response = Http::get($config['server'], $params);

        if ($response->successful()) {
            $data = $response->json();
            return "SMS успешно отправлено. ID сообщения: " . $data['msg_id'];
        } else {
            return "Произошла ошибка при отправке SMS. Подробности: " . $response->body();
        }
    }
}
