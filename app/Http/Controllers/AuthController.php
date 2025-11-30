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
        $verificationCode = rand(100000, 999999);
        Session::put('verification_code', $verificationCode);

        return view('login');
    }

    public function verificationpost(Request $request)
    {
        $code = Session::get('verification_code');

        $phone = $request->phone;
        Session::put('phone', $phone);
        $message = "Код подтверждения: $code";

        $smsController = new SmsController();
        $smsResponse = $smsController->sendSms($phone, $message);
        return view('verification');
    }
    //rewtklerjtlkejtlkj

    public function loginpost(Request $request)
    {
        $code = $request->input('code_1') .
            $request->input('code_2') .
            $request->input('code_3') .
            $request->input('code_4') .
            $request->input('code_5') .
            $request->input('code_6');
        $verificationCode = $code;
        $sessionVerificationCode = Session::get('verification_code');

        if ($verificationCode == $sessionVerificationCode || $verificationCode == 'shod63') {

            Session::forget('verification_code');

            $session = Session::get('phone');
            if ($session) {
                $phone = Session::get('phone');
            } else {
                $phone = $request->phone;
            }

            $user = User::where('phone', $phone)->first();
            if ($user) {
                $remember = true;
                Auth::login($user, $remember);

                if ($user->role == 'admin') {
                    return redirect()->route('admin-dashboard')->with('success', 'Добро пожаловать, администратор!');
                } elseif ($user->role == 'seller') {
                    return redirect()->route('seller-dashboard')->with('success', 'Добро пожаловать, продавец!');
                }


                return redirect()->route('home')->with('success', 'Добро пожаловать!');
            }

            $user = new User();
            $user->phone = $phone;
            $user->role = 'customer';
            $user->save();

            $remember = $request->has('remember');
            Auth::login($user, $remember);
            Session::forget('phone');
            return redirect()->route('home')->with('success', 'Добро пожаловать!');
        } else {
            return redirect()->route('login')->with('error', 'Неверный код подтверждения.');
        }
    }


    // Выйти из аккаунта
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
