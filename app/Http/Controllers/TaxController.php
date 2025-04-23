<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function setting()
    {
        $tax = Tax::find(1);
        $delivery = Tax::find(2);
        return view('admin.pages.setting', compact('tax', 'delivery'));
    }
    public function tax(Request $request)
    {
        Tax::updateOrCreate(
            ['id' => 1],
            ['tax' => $request->tax]
        );
        return back()->with('success', 'Налог успешно обновлен!');
    }
    public function delivery(Request $request)
    {
        Tax::updateOrCreate(
            ['id' => 2],
            ['tax' => $request->delivery]
        );
        return back()->with('success', 'Цена доставка успешно обновлен!');
    }
}
