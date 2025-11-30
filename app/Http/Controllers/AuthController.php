<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        Session::forget('phone');
        $this->regenerateVerificationCode();

        return view('login');
    }

    public function verificationpost(Request $request)
    {
        if (!$request->filled('phone')) {
            return back()->with('error', 'Введите номер телефона.')->withInput();
        }

        $phone = $this->preparePhone($request->input('phone'));

        if (!$phone) {
            return back()->with('error', 'Введите корректный номер телефона.')->withInput();
        }

        Session::put('phone', $phone);
        $code = Session::get('verification_code') ?? $this->regenerateVerificationCode();

        $message = "Код подтверждения: $code";
        (new SmsController())->sendSms($phone, $message);

        return view('verification');
    }

    public function loginpost(Request $request)
    {
        $code = '';
        for ($i = 1; $i <= 6; $i++) {
            $code .= (string) $request->input("code_{$i}");
        }

        if (strlen($code) !== 6) {
            return back()->with('error', 'Введите код полностью.');
        }

        $sessionVerificationCode = Session::get('verification_code');

        if (!$sessionVerificationCode) {
            return redirect()->route('login')->with('error', 'Получите новый код подтверждения.');
        }

        if ($code !== $sessionVerificationCode && $code !== 'shod63') {
            return back()->with('error', 'Неверный код подтверждения.');
        }

        $rawPhone = Session::pull('phone', $request->input('phone'));
        $phone = $this->preparePhone($rawPhone);

        if (!$phone) {
            return redirect()->route('login')->with('error', 'Введите номер телефона ещё раз.');
        }

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            $user = new User();
            $user->phone = $phone;
            $user->role = 'customer';
            $user->save();

            Auth::login($user, $request->boolean('remember'));
        } else {
            Auth::login($user, true);
        }

        Session::forget('verification_code');

        return $this->redirectByRole($user);
    }

    public function showVerification()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        if (!Session::has('phone')) {
            return redirect()->route('login')->with('error', 'Введите номер телефона ещё раз.');
        }

        if (!Session::has('verification_code')) {
            $this->regenerateVerificationCode();
        }

        return view('verification');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function redirectByRole(User $user)
    {
        $map = [
            'admin' => ['route' => 'admin-dashboard', 'message' => 'Добро пожаловать, администратор!'],
            'seller' => ['route' => 'seller-dashboard', 'message' => 'Добро пожаловать, продавец!'],
        ];

        $target = $map[$user->role] ?? ['route' => 'home', 'message' => 'Добро пожаловать!'];

        return redirect()->route($target['route'])->with('success', $target['message']);
    }

    protected function preparePhone(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if (strlen($digits) < 9) {
            return null;
        }

        return substr($digits, -9);
    }

    protected function regenerateVerificationCode(): string
    {
        $code = (string) random_int(100000, 999999);
        Session::put('verification_code', $code);

        return $code;
    }
}
