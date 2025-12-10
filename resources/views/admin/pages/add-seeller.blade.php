@extends('admin.layouts.app')

@section('content')
@php
    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
@endphp

<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Продавцы</p>
                <h1 class="text-3xl font-semibold text-gray-900">Регистрация продавца</h1>
                <p class="text-sm text-gray-500">Заполните данные магазина и загрузите документы для проверки.</p>
            </div>
            <a href="{{ route('sellers') }}"
                class="inline-flex items-center rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                ← Вернуться к списку
            </a>
        </div>
    </header>

    <form action="{{ route('seller-register') }}" method="POST" enctype="multipart/form-data"
        class="grid gap-6 lg:grid-cols-2">
        @csrf
        <div class="space-y-4 rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Информация о магазине</p>
            <div>
                <label for="store_name" class="text-sm font-semibold text-gray-700">Название магазина</label>
                <input type="text" name="store_name" id="store_name" required placeholder="Boron Market"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="store_phone" class="text-sm font-semibold text-gray-700">Телефон</label>
                <input type="text" name="store_phone" id="store_phone" required placeholder="+992 900 00 00 00"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="description" class="text-sm font-semibold text-gray-700">Описание</label>
                <textarea name="description" id="description" rows="5" placeholder="Кратко расскажите о магазине"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>
        </div>

        <div class="space-y-4 rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Документы</p>
            <label class="flex flex-col rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500">
                <span class="font-semibold text-gray-900">Логотип магазина</span>
                <input type="file" name="logo" id="logo" class="mt-3 text-sm text-gray-500" {{ $isAdmin ? '' : 'required' }}>
            </label>
            <label class="flex flex-col rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500">
                <span class="font-semibold text-gray-900">Патент</span>
                <input type="file" name="patent" id="patent" class="mt-3 text-sm text-gray-500" {{ $isAdmin ? '' : 'required' }}>
            </label>
            <label class="flex flex-col rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500">
                <span class="font-semibold text-gray-900">Паспорт (лицевой)</span>
                <input type="file" name="passport_front" id="passport_front" class="mt-3 text-sm text-gray-500" {{ $isAdmin ? '' : 'required' }}>
            </label>
            <label class="flex flex-col rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500">
                <span class="font-semibold text-gray-900">Паспорт (оборот)</span>
                <input type="file" name="passport_back" id="passport_back" class="mt-3 text-sm text-gray-500" {{ $isAdmin ? '' : 'required' }}>
            </label>
        </div>

        <div class="lg:col-span-2 flex justify-end gap-3">
            <a href="{{ route('sellers') }}"
                class="inline-flex items-center rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                Отмена
            </a>
            <button type="submit"
                class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                Зарегистрировать продавца
            </button>
        </div>
    </form>
</section>
@endsection
