@extends('admin.layouts.app')

@section('content')
@php
    $statusBadge = $deliver->status
        ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
        : 'bg-rose-50 text-rose-700 ring-rose-200';
    $onlineBadge = $deliver->isonline
        ? 'bg-blue-50 text-blue-700 ring-blue-200'
        : 'bg-gray-100 text-gray-500 ring-gray-200';
@endphp

<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Доставщики</p>
                <h1 class="text-3xl font-semibold text-gray-900">{{ $deliver->name }}</h1>
                <p class="text-sm text-gray-500">Телефон: <a href="tel:+992{{ $deliver->phone }}" class="font-semibold text-indigo-600">+992 {{ $deliver->phone }}</a></p>
            </div>
            <a href="{{ route('delivers') }}"
                class="inline-flex items-center rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                ← Вернуться к списку
            </a>
        </div>
    </header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-3xl bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Статус</p>
            <p class="mt-3">
                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusBadge }}">
                    <span>●</span>{{ $deliver->status ? 'Активен' : 'Не активен' }}
                </span>
            </p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Онлайн</p>
            <p class="mt-3">
                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $onlineBadge }}">
                    {{ $deliver->isonline ? 'В сети' : 'Оффлайн' }}
                </span>
            </p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Добавлен</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ optional($deliver->created_at)->format('d.m.Y') }}</p>
            <p class="text-sm text-gray-500">{{ optional($deliver->created_at)->format('H:i') }}</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Контакты</p>
            <dl class="mt-4 space-y-3 text-sm text-gray-600">
                <div>
                    <dt class="text-xs uppercase text-gray-400">Имя</dt>
                    <dd class="text-lg font-semibold text-gray-900">{{ $deliver->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase text-gray-400">Телефон</dt>
                    <dd class="text-lg font-semibold text-gray-900">+992 {{ $deliver->phone }}</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Действия</p>
            <div class="mt-4 space-y-3 text-sm">
                <a href="tel:+992{{ $deliver->phone }}" class="flex items-center justify-between rounded-2xl border border-gray-100 p-4 hover:bg-gray-50">
                    <span>Позвонить</span>
                    <span class="text-xs text-gray-400">Телефон</span>
                </a>
                <a href="mailto:{{ $deliver->email ?? '' }}" class="flex items-center justify-between rounded-2xl border border-gray-100 p-4 hover:bg-gray-50">
                    <span>Написать письмо</span>
                    <span class="text-xs text-gray-400">Email</span>
                </a>
            </div>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Документы</p>
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            <div class="space-y-3 rounded-2xl border border-gray-100 bg-gray-50 p-4">
                <p class="text-sm font-semibold text-gray-900">Паспорт • лицевая сторона</p>
                @if($deliver->passport_front)
                    <img src="{{ asset('storage/'.$deliver->passport_front) }}" alt="Паспорт (лицевой)"
                        class="h-64 w-full rounded-2xl object-cover">
                @else
                    <p class="text-xs text-gray-400">Файл не загружен</p>
                @endif
            </div>
            <div class="space-y-3 rounded-2xl border border-gray-100 bg-gray-50 p-4">
                <p class="text-sm font-semibold text-gray-900">Паспорт • обратная сторона</p>
                @if($deliver->passport_back)
                    <img src="{{ asset('storage/'.$deliver->passport_back) }}" alt="Паспорт (обратный)"
                        class="h-64 w-full rounded-2xl object-cover">
                @else
                    <p class="text-xs text-gray-400">Файл не загружен</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
