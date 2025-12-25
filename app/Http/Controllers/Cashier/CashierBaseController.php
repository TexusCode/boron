<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;

abstract class CashierBaseController extends Controller
{
    protected function viewOptions(): array
    {
        $isManager = request()->routeIs('manager.cashier.*');

        return [
            'layout' => $isManager ? 'manager.layouts.app' : 'cashier.layouts.app',
            'routePrefix' => $isManager ? 'manager.cashier.' : 'cashier.',
        ];
    }

    protected function routePrefix(): string
    {
        return $this->viewOptions()['routePrefix'];
    }
}
