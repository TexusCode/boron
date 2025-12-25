@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Отзывы</p>
                <h1 class="text-3xl font-semibold text-gray-900">Отзывы клиентов</h1>
                <p class="text-sm text-gray-500">Список отзывов по доставленным заказам.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Всего отзывов</p>
                <p class="text-2xl font-semibold text-indigo-600">{{ $reviews->total() }}</p>
            </div>
        </div>
    </header>

    <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-100 text-sm text-gray-700">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-6 py-3 text-left">Заказ</th>
                    <th class="px-6 py-3 text-left">Клиент</th>
                    <th class="px-6 py-3 text-left">Оценка</th>
                    <th class="px-6 py-3 text-left">Отзыв</th>
                    <th class="px-6 py-3 text-left">Дата</th>
                    <th class="px-6 py-3 text-left">Детали</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($reviews as $review)
                    <tr>
                        <td class="px-6 py-4 font-semibold text-gray-900">#{{ $review->order_id }}</td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $review->order->user->name ?? '—' }}</p>
                            <p class="text-xs text-gray-500">+992 {{ $review->order->user->phone ?? '—' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                {{ $review->rating }} / 5
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="line-clamp-2">{{ $review->comment ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ optional($review->created_at)->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.reviews.show', $review) }}"
                                class="inline-flex items-center rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-600 hover:bg-gray-50">
                                Открыть
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                            Отзывов пока нет.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="rounded-3xl border border-gray-100 bg-white px-6 py-4 shadow-sm">
        {{ $reviews->links('pagination::simple-tailwind') }}
    </div>
</section>
@endsection
