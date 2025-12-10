<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Jobs\SendSmsJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PagesController extends Controller
{
    public function smspage()
    {
        $clients = User::orderByDesc('created_at')->paginate(25);
        $stats = [
            'total' => User::count(),
            'enabled' => User::where('sms_notifications', true)->count(),
        ];

        return view('admin.pages.sms-page', compact('clients', 'stats'));
    }
    public function smsmany(Request $request)
    {
        ini_set('max_execution_time', 5000);
        $message = $request->simpleMessage;

        if (!$message) {
            return back()->with('error', 'Сообщение не может быть пустым');
        }

        $users = User::where('sms_notifications', true)->pluck('phone');

        foreach ($users as $phone) {
            SendSmsJob::dispatch($phone, $message);
        }

        return back()->with('success', 'Сообщения поставлены в очередь на отправку.');
    }

    public function onesms(Request $request)
    {
        $phone = $request->phone;
        $message = $request->message;

        // Проверка, что номер и сообщение заполнены
        if (!$phone || !$message) {
            return back()->with('error', 'Пожалуйста, укажите номер телефона и сообщение');
        }

        SendSmsJob::dispatch($phone, $message);

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

    public function storeSmsClient(Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32'],
            'sms_notifications' => ['nullable', 'boolean'],
        ]);

        $user = User::firstOrNew(['phone' => $validated['phone']]);
        if (!empty($validated['name'])) {
            $user->name = $validated['name'];
        }
        if (!$user->exists) {
            $user->role = 'customer';
        }
        $user->sms_notifications = $request->boolean('sms_notifications', true);
        $user->save();

        return back()->with('success', 'Клиент сохранён.');
    }

    public function toggleSmsClient(User $user)
    {
        $user->sms_notifications = ! $user->sms_notifications;
        $user->save();

        return back()->with('success', 'Настройка SMS обновлена.');
    }
}
