@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Коммуникации</p>
                <h1 class="text-3xl font-semibold text-gray-900">SMS панель</h1>
                <p class="text-sm text-gray-500">Рассылайте сообщения клиентам и управляйте их подписками.</p>
            </div>
            <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                <span class="rounded-2xl bg-gray-100 px-4 py-2">Всего: <strong>{{ $stats['total'] }}</strong></span>
                <span class="rounded-2xl bg-emerald-50 px-4 py-2 text-emerald-700">Подписаны: <strong>{{ $stats['enabled'] }}</strong></span>
            </div>
        </div>
    </header>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Действия</p>
                <h2 class="text-xl font-semibold text-gray-900">Быстрые операции</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                <button type="button" data-modal-target="single-sms-modal" data-modal-toggle="single-sms-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">SMS одному</button>
                <button type="button" data-modal-target="bulk-sms-modal" data-modal-toggle="bulk-sms-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Рассылка</button>
                <button type="button" data-modal-target="client-modal" data-modal-toggle="client-modal"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">+ Клиент</button>
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Клиент</th>
                        <th class="px-5 py-3 text-left">Телефон</th>
                        <th class="px-5 py-3 text-left">SMS</th>
                        <th class="px-5 py-3 text-right">Дата</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($clients as $client)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $client->name ?? 'Без имени' }}</td>
                            <td class="px-5 py-4">+992 {{ $client->phone }}</td>
                            <td class="px-5 py-4">
                                <form action="{{ route('sms-clients.toggle', $client) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold
                                            {{ $client->sms_notifications ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-gray-100 text-gray-500 ring-gray-200' }}">
                                        <span class="h-2 w-2 rounded-full {{ $client->sms_notifications ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                        {{ $client->sms_notifications ? 'Включено' : 'Выключено' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-4 text-right text-xs text-gray-500">{{ optional($client->created_at)->format('d.m.Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-5 py-4">
            {{ $clients->links('pagination::simple-tailwind') }}
        </div>
    </div>
</section>

<div id="single-sms-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">SMS одному</p>
                <h3 class="text-lg font-semibold text-gray-900">Отправить сообщение</h3>
            </div>
            <button type="button" data-modal-hide="single-sms-modal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <form action="{{ route('onesms') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700">Номер телефона</label>
                <input type="tel" name="phone" required placeholder="+992901234567"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Сообщение</label>
                <textarea name="message" rows="4" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Введите текст..."></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="single-sms-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Отправить</button>
            </div>
        </form>
    </div>
</div>

<div id="bulk-sms-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Рассылка</p>
                <h3 class="text-lg font-semibold text-gray-900">Сообщение подписчикам</h3>
            </div>
            <button type="button" data-modal-hide="bulk-sms-modal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <form action="{{ route('sms-many') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700">Сообщение</label>
                <textarea name="simpleMessage" rows="5" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Введите текст..."></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="bulk-sms-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Отправить</button>
            </div>
        </form>
    </div>
</div>

<div id="client-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Клиент</p>
                <h3 class="text-lg font-semibold text-gray-900">Добавить клиента</h3>
            </div>
            <button type="button" data-modal-hide="client-modal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <form action="{{ route('sms-clients.store') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700">Имя</label>
                <input type="text" name="name" placeholder="Имя клиента"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Телефон</label>
                <input type="tel" name="phone" required placeholder="+992901234567"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                <input type="checkbox" name="sms_notifications" value="1" checked class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                Получать рассылки
            </label>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="client-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Сохранить</button>
            </div>
        </form>
    </div>
</div>
@endsection
