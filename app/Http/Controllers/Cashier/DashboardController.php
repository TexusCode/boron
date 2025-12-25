<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('cashier.orders.create');
    }
}
