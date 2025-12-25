@extends('courier.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white/90 p-6 shadow-sm ring-1 ring-white/60">
        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Профиль</p>
        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Настройки курьера</h2>
        <p class="mt-2 text-sm text-slate-500">Проверьте данные профиля и контакты.</p>
    </header>

    <div class="rounded-3xl bg-white/90 p-6 shadow-sm ring-1 ring-white/60">
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs uppercase text-slate-400">Имя в системе</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $user->name ?? '—' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs uppercase text-slate-400">Телефон</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">+992 {{ $user->phone ?? '—' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs uppercase text-slate-400">Роль</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $user->role ?? '—' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs uppercase text-slate-400">Дата регистрации</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">
                    {{ optional($user->created_at)->format('d.m.Y') }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
