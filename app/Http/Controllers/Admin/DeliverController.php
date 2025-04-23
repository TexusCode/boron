<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deliver;
use Illuminate\Http\Request;

class DeliverController extends Controller
{
    public function adddeliver()
    {
        return view('admin.pages.add-deliver');
    }
    public function addDeliveryPerson(Request $request)
    {

        $deliveryPerson = new Deliver();
        $deliveryPerson->name = $request->name;
        $deliveryPerson->phone = $request->phone;

        // Store Passport Front
        if ($request->hasFile('passport_front')) {
            $pathFront = $request->file('passport_front')->store('passports/front', 'public');
            $deliveryPerson->passport_front = $pathFront;
        }

        // Store Passport Back
        if ($request->hasFile('passport_back')) {
            $pathBack = $request->file('passport_back')->store('passports/back', 'public');
            $deliveryPerson->passport_back = $pathBack;
        }

        $deliveryPerson->save();

        return back()->with('success', 'Доставщик успешно добавлен');
    }

    public function showDeliveryPersons()
    {
        $delivers = Deliver::all(); // Adjust the query as needed

        return view('admin.pages.delivers', compact('delivers'));
    }
    public function showdeliver($id)
    {
        $deliver = Deliver::findOrFail($id); // Adjust to your model and logic
        return view('admin.pages.deliver-details
        ', compact('deliver'));
    }
}
