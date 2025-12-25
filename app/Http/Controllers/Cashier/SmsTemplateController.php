<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;
use Illuminate\Http\Request;

class SmsTemplateController extends Controller
{
    public function index()
    {
        $templates = SmsTemplate::orderBy('title')->get();

        return view('cashier.pages.sms-templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        SmsTemplate::create($data);

        return back()->with('success', 'Шаблон создан.');
    }

    public function update(Request $request, SmsTemplate $template)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $template->update($data);

        return back()->with('success', 'Шаблон обновлен.');
    }

    public function destroy(SmsTemplate $template)
    {
        $template->delete();

        return back()->with('success', 'Шаблон удален.');
    }
}
