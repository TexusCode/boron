@extends($layout ?? 'cashier.layouts.app')

@php($routePrefix = $routePrefix ?? 'cashier.')

@section('content')
<section class="rounded-3xl bg-white p-8 shadow-sm">
    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Касса</p>
    <h1 class="mt-2 text-2xl font-semibold text-slate-900">Панель кассира</h1>
    <p class="mt-2 text-sm text-slate-500">Выберите нужный раздел в меню сверху.</p>

    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <a href="{{ route($routePrefix . 'orders.create') }}" class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-sm font-semibold text-slate-700 hover:bg-white">
            Создать заказ →
        </a>
        <a href="{{ route($routePrefix . 'sms-templates.index') }}" class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-sm font-semibold text-slate-700 hover:bg-white">
            SMS шаблоны →
        </a>
    </div>
</section>
@endsection
