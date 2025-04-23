<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function smspage()
    {
        return view('admin.pages.sms-page');
    }
    public function smsmany(Request $request)
    {
        ini_set('max_execution_time', 5000);
        $users = User::all();
        $message = $request->simpleMessage;

        // Проверка, что сообщение не пустое
        if (!$message) {
            return back()->with('error', 'Сообщение не может быть пустым');
        }

        // Отправка сообщения всем пользователям
        foreach ($users as $user) {
            $this->sendSmsToUser($user->phone, $message);
        }

        return back()->with('success', 'Сообщения успешно отправлены всем пользователям');
    }

    public function onesms(Request $request)
    {
        $phone = $request->phone;
        $message = $request->message;

        // Проверка, что номер и сообщение заполнены
        if (!$phone || !$message) {
            return back()->with('error', 'Пожалуйста, укажите номер телефона и сообщение');
        }

        // Отправка одного сообщения
        $this->sendSmsToUser($phone, $message);

        return back()->with('success', 'Сообщение успешно отправлено');
    }

    // Вспомогательный метод для отправки SMS
    private function sendSmsToUser($phone, $message)
    {
        $smsController = new SmsController();
        $smsController->sendSms($phone, $message);
    }
}
