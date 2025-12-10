<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function account()
    {
        $admin = Auth::user();
        return view('admin.pages.account', compact('admin'));
    }

    public function updateAccount(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $admin->id],
            'phone' => ['nullable', 'string', 'max:32'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return back()->with('success', 'Данные аккаунта обновлены.');
    }
}
