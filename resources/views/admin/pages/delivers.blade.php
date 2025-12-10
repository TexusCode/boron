@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Операции</p>
                <h1 class="text-3xl font-semibold text-gray-900">Доставщики</h1>
                <p class="text-sm text-gray-500">Управляйте курьерами, отслеживайте их статус и доступность онлайн.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('add-deliver') }}" class="rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                    Полная регистрация
                </a>
                <button type="button" data-modal-target="deliver-modal" data-modal-toggle="deliver-modal"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                    + Быстро добавить
                </button>
            </div>
        </div>
    </header>

    <div class="rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Имя</th>
                        <th class="px-5 py-3 text-left">Телефон</th>
                        <th class="px-5 py-3 text-left">Статус</th>
                        <th class="px-5 py-3 text-left">Онлайн</th>
                        <th class="px-5 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($delivers as $deliver)
                        @php
                            $statusBadge = $deliver->status
                                ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
                                : 'bg-rose-50 text-rose-700 ring-rose-200';
                            $onlineBadge = $deliver->isonline
                                ? 'bg-blue-50 text-blue-700 ring-blue-200'
                                : 'bg-gray-100 text-gray-500 ring-gray-200';
                        @endphp
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $deliver->name }}</td>
                            <td class="px-5 py-4">+992 {{ $deliver->phone }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusBadge }}">
                                    <span>●</span>{{ $deliver->status ? 'Активен' : 'Не активен' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $onlineBadge }}">
                                    {{ $deliver->isonline ? 'В сети' : 'Оффлайн' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('show-deliver', $deliver->id) }}"
                                    class="inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 hover:bg-indigo-600 hover:text-white">
                                    Подробнее
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<div id="deliver-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Доставщик</p>
                <h3 class="text-lg font-semibold text-gray-900">Быстрое добавление</h3>
            </div>
            <button type="button" data-modal-hide="deliver-modal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <form action="{{ route('add-deliver-post') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            <div>
                <label for="modal_name" class="text-sm font-semibold text-gray-700">Имя</label>
                <input type="text" id="modal_name" name="name" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="modal_phone" class="text-sm font-semibold text-gray-700">Телефон</label>
                <input type="text" id="modal_phone" name="phone" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <label class="flex flex-col rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500">
                <span class="font-semibold text-gray-900">Паспорт (лицевой)</span>
                <input type="file" name="passport_front" accept="image/*" class="mt-3 text-sm text-gray-500">
            </label>
            <label class="flex flex-col rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500">
                <span class="font-semibold text-gray-900">Паспорт (оборот)</span>
                <input type="file" name="passport_back" accept="image/*" class="mt-3 text-sm text-gray-500">
            </label>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="deliver-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Добавить</button>
            </div>
        </form>
    </div>
</div>
@endsection
