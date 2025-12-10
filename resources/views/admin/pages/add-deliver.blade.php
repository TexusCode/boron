@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Доставщики</p>
                <h1 class="text-3xl font-semibold text-gray-900">Добавить доставщика</h1>
                <p class="text-sm text-gray-500">Заполните контактные данные и добавьте фото паспорта.</p>
            </div>
            <a href="{{ route('delivers') }}" class="inline-flex items-center rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                ← Вернуться к списку
            </a>
        </div>
    </header>

    <form action="{{ route('add-deliver-post') }}" method="POST" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-2">
        @csrf
        <div class="space-y-4 rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Основная информация</p>
            <div>
                <label for="name" class="text-sm font-semibold text-gray-700">Имя доставщика</label>
                <input type="text" id="name" name="name" required placeholder="Например, Абдулло"
                       class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="phone" class="text-sm font-semibold text-gray-700">Телефон</label>
                <input type="text" id="phone" name="phone" required placeholder="+992 900 00 00 00"
                       class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>
        <div class="space-y-4 rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Документы</p>
            <label class="flex flex-col rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500">
                <span class="font-semibold text-gray-900">Паспорт (лицевой)</span>
                <input type="file" id="passport_front" name="passport_front" accept="image/*" class="mt-3 text-sm text-gray-500">
            </label>
            <label class="flex flex-col rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500">
                <span class="font-semibold text-gray-900">Паспорт (обратный)</span>
                <input type="file" id="passport_back" name="passport_back" accept="image/*" class="mt-3 text-sm text-gray-500">
            </label>
        </div>
        <div class="lg:col-span-2 flex justify-end gap-3">
            <a href="{{ route('delivers') }}" class="inline-flex items-center rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</a>
            <button type="submit" class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Добавить доставщика</button>
        </div>
    </form>
</section>
@endsection
