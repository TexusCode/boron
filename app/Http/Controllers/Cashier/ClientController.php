<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('cashier.pages.clients.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32'],
        ]);

        $user = User::firstOrNew(['phone' => $data['phone']]);
        if (!$user->exists) {
            $user->role = 'customer';
        }
        $user->name = $data['name'];
        $user->save();

        return back()->with('success', 'Клиент сохранён.');
    }
}
