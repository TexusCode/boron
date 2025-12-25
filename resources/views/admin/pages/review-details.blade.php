@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Отзыв</p>
                <h1 class="text-3xl font-semibold text-gray-900">Отзыв по заказу #{{ $review->order_id }}</h1>
                <p class="text-sm text-gray-500">Полный текст отзыва клиента.</p>
            </div>
            <a href="{{ route('admin.reviews') }}"
                class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                ← Назад к списку
            </a>
        </div>
    </header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl bg-white p-6 shadow-sm lg:col-span-2">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Текст отзыва</p>
            <div class="mt-4 rounded-2xl border border-gray-100 bg-gray-50 p-5 text-sm text-gray-700">
                {{ $review->comment ?? '—' }}
            </div>
        </div>
        <div class="space-y-4">
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Клиент</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $review->order->user->name ?? '—' }}</p>
                <p class="text-sm text-gray-500">+992 {{ $review->order->user->phone ?? '—' }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Оценка</p>
                <p class="mt-2 text-2xl font-semibold text-indigo-600">{{ $review->rating }} / 5</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Дата</p>
                <p class="mt-2 text-sm font-semibold text-gray-900">{{ optional($review->created_at)->format('d.m.Y H:i') }}</p>
            </div>
        </div>
    </div>
</section>
@endsection
