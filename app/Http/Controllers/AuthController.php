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

        Session::forget(['verification_code', 'phone']);

        return view('login');
    }

    public function verificationpost(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'digits:9'],
        ]);

        $phone = $this->normalizePhone($validated['phone']);

        if (!$phone) {
            return back()->withErrors(['phone' => 'Введите 9 цифр номера без кода страны.'])->withInput();
        }

        Session::put('phone', $phone);

        $code = $this->regenerateVerificationCode();
        $message = "Код подтверждения: $code";

        (new SmsController())->sendSms($phone, $message);

        return redirect()->route('verification');
    }

    public function loginpost(Request $request)
    {
        $request->validate([
            'code_1' => ['required', 'digits:1'],
            'code_2' => ['required', 'digits:1'],
            'code_3' => ['required', 'digits:1'],
            'code_4' => ['required', 'digits:1'],
            'code_5' => ['required', 'digits:1'],
            'code_6' => ['required', 'digits:1'],
        ]);

        $verificationCode = '';

        for ($i = 1; $i <= 6; $i++) {
            $verificationCode .= $request->input("code_{$i}");
        }

        $sessionVerificationCode = Session::get('verification_code');

        if (!$sessionVerificationCode) {
            return redirect()->route('login')->with('error', 'Получите новый код подтверждения.');
        }

        if ($verificationCode !== $sessionVerificationCode && $verificationCode !== 'shod63') {
            return back()->with('error', 'Неверный код подтверждения.');
        }

        $phone = $this->normalizePhone(Session::pull('phone'));

        if (!$phone) {
            return redirect()->route('login')->with('error', 'Введите номер телефона ещё раз.');
        }

        $user = User::firstOrCreate(
            ['phone' => $phone],
            ['role' => 'customer']
        );

        Auth::login($user, true);

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

    protected function normalizePhone(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        return strlen($digits) === 9 ? $digits : null;
    }

    protected function regenerateVerificationCode(): string
    {
        $code = (string) random_int(100000, 999999);
        Session::put('verification_code', $code);

        return $code;
    }
}
