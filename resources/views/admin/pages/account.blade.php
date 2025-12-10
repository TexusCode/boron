@extends('admin.layouts.app')

@section('content')
<section class="space-y-8">
    <header class="rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-fuchsia-600 px-6 py-8 text-white shadow-2xl">
        <p class="text-xs uppercase tracking-[0.4em] text-white/70">Профиль</p>
        <h1 class="mt-2 text-3xl font-semibold">Настройки аккаунта</h1>
        <p class="mt-2 text-sm text-white/80">Обновите контактные данные администратора и, при необходимости, смените пароль.</p>
    </header>

    @if (session('success'))
        <div class="rounded-3xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 shadow-lg shadow-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.account.update') }}" method="POST" class="space-y-6">
        @csrf
        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
            <h2 class="text-lg font-semibold text-gray-900">Основная информация</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="space-y-1">
                    <label for="name" class="text-sm font-semibold text-gray-600">Имя</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="space-y-1">
                    <label for="email" class="text-sm font-semibold text-gray-600">Электронная почта</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="space-y-1">
                    <label for="phone" class="text-sm font-semibold text-gray-600">Телефон</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="space-y-1">
                    <label for="password" class="text-sm font-semibold text-gray-600">Новый пароль</label>
                    <input type="password" id="password" name="password"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Оставьте пустым, если не нужно менять">
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
            <h2 class="text-lg font-semibold text-gray-900">Дополнительно</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="space-y-1">
                    <label for="role" class="text-sm font-semibold text-gray-600">Роль</label>
                    <input type="text" id="role" value="Администратор" disabled
                        class="w-full rounded-2xl border border-gray-200 bg-gray-100 px-4 py-3 text-sm font-medium text-gray-500">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-600">Последний вход</label>
                    <input type="text" value="{{ optional($admin->last_login_at)->format('d.m.Y H:i') ?? '—' }}" disabled
                        class="w-full rounded-2xl border border-gray-200 bg-gray-100 px-4 py-3 text-sm font-medium text-gray-500">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-indigo-200 transition hover:shadow-indigo-300">
                Сохранить изменения
            </button>
        </div>
    </form>
</section>
@endsection
