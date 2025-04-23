<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmpliyoneController extends Controller
{
    public function addempliyone($phone = null)
    {
        $employee = User::where('phone', $phone)->first();

        return view('admin.pages.add-empliyone', compact('employee'));
    }
    public function delempliyonepost($id)
    {
        $employee = User::find($id);
        if ($employee) {
            $employee->delete();
            return back()->with('success', 'Успешно удалено');
        }
        return back()->with('error', 'Сотрудник не найден');
    }

    public function addempliyonepost(Request $request)
    {
        // Проверяем, существует ли сотрудник с указанным номером телефона
        $employee = User::where('phone', $request->phone)->first();

        if ($employee) {
            // Если сотрудник найден, обновляем его роль
            $employee->role = $request->role;
            $employee->save();

            return back()->with('message', "Роль сотрудника {$employee->name} обновлена на {$employee->role}.");
        } else {
            // Если сотрудник не найден, создаем нового
            $employee = new User();
            $employee->name = $request->name;
            $employee->phone = $request->phone;
            $employee->role = $request->role;
            $employee->save();

            return back()->with('message', "Сотрудник {$employee->name} успешно добавлен.");
        }
    }

    public function empliyones()
    {
        $employees = User::whereNotIn('role', ['customer', 'seller'])->get();
        return view('admin.pages.empliyones', compact('employees'));
    }
}
