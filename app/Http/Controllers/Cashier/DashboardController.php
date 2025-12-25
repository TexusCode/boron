<?php

namespace App\Http\Controllers\Cashier;

class DashboardController extends CashierBaseController
{
    public function index()
    {
        return redirect()->route($this->routePrefix() . 'orders.create');
    }
}
