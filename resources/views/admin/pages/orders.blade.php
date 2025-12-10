@extends('admin.layouts.app')
@section('content')
<section class="space-y-6">
    @php
        $statuses = [
            'all' => 'Все',
            'Ожидание' => 'В ожидании',
            'Подтверждено' => 'Подтверждено',
            'Отправлен' => 'Отправлено',
            'Доставлен' => 'Доставлено',
            'Отменено' => 'Отменено',
        ];
        $statusBadge = [
            'Ожидание' => 'bg-amber-50 text-amber-700 ring-amber-200',
            'Подтверждено' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'Отправлен' => 'bg-blue-50 text-blue-700 ring-blue-200',
            'Доставлен' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
            'Отменено' => 'bg-rose-50 text-rose-700 ring-rose-200',
        ];
    @endphp

    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Заказы</p>
                <h1 class="text-2xl font-semibold text-gray-900">Панель заказов</h1>
                <p class="text-sm text-gray-500">Управляйте заказами, фильтруйте по статусу и следите за динамикой.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Всего заказов</p>
                <p class="text-2xl font-semibold text-indigo-600">{{ $orders->total() }}</p>
            </div>
        </div>
        @php
            $persistentFilters = array_filter(request()->only(['search', 'date_from', 'date_to']), fn ($value) => filled($value));
        @endphp
        <div class="mt-4 flex flex-wrap gap-3 text-xs font-semibold">
            @foreach ($statuses as $key => $label)
                @php
                    $statusQuery = $key === 'all' ? [] : ['status' => $key];
                    $tabQuery = array_filter(array_merge($persistentFilters, $statusQuery), fn ($value) => filled($value));
                @endphp
                <a href="{{ route('orders', $tabQuery) }}"
                    @class([
                        'rounded-full px-4 py-2 transition',
                        'bg-indigo-600 text-white shadow' => (request('status', 'all') === $key) || (request('status') === null && $key === 'all'),
                        'bg-gray-100 text-gray-600 hover:bg-gray-200' => request('status', 'all') !== $key,
                    ])>
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </header>

    <form class="grid gap-4 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm md:grid-cols-4" method="GET">
        <div class="space-y-1">
            <label class="text-xs font-semibold text-gray-500">Поиск</label>
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                   class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                   placeholder="ID, телефон или имя">
        </div>
        <div class="space-y-1">
            <label class="text-xs font-semibold text-gray-500">Статус</label>
            <select name="status" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="all">Все</option>
                @foreach ($statuses as $key => $label)
                    @if($key !== 'all')
                        <option value="{{ $key }}" {{ (request('status') === $key) ? 'selected' : '' }}>{{ $label }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="space-y-1">
            <label class="text-xs font-semibold text-gray-500">Дата от</label>
            <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                   class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div class="space-y-1">
            <label class="text-xs font-semibold text-gray-500">Дата до</label>
            <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                   class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div class="flex gap-3 md:col-span-4">
            <button type="submit" class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow">Применить</button>
            <a href="{{ route('orders') }}" class="inline-flex items-center rounded-2xl bg-gray-100 px-5 py-2 text-sm font-semibold text-gray-600">Сбросить</a>
        </div>
    </form>

    <div class="rounded-3xl border border-gray-100 bg-white p-0 shadow-xl">
        <div class="overflow-x-auto rounded-3xl">
            <table class="min-w-full divide-y divide-gray-100 text-sm text-gray-700">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left">#</th>
                        <th class="px-5 py-3 text-left">Клиент</th>
                        <th class="px-5 py-3 text-left">Дата</th>
                        <th class="px-5 py-3 text-left">Статус</th>
                        <th class="px-5 py-3 text-left">Сумма</th>
                        <th class="px-5 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-5 py-4 font-semibold text-gray-900">#{{ $order->id }}</td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-900">{{ $order->user->name ?? 'Неизвестно' }}</p>
                                <p class="text-xs text-gray-500">+992 {{ $order->user->phone ?? '—' }}</p>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ optional($order->created_at)->format('d.m.Y H:i') }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusBadge[$order->status] ?? 'bg-gray-50 text-gray-600 ring-gray-200' }}">
                                    <span>●</span>{{ $order->status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ number_format($order->total, 2, '.', ' ') }} c</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('order-details', $order->id) }}"
                                        class="inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 hover:bg-indigo-600 hover:text-white">
                                        Просмотр
                                    </a>
                                    <button type="button" data-id="{{ $order->id }}"
                                        class="delete-order inline-flex items-center rounded-full border border-rose-100 bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-500 hover:text-white">
                                        Удалить
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-5 py-4">
            {{ $orders->links('pagination::simple-tailwind') }}
        </div>
    </div>
</section>

<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
        <h3 class="text-lg font-semibold text-gray-900">Удалить заказ</h3>
        <p class="mt-2 text-sm text-gray-500">Вы уверены, что хотите удалить этот заказ? Действие необратимо.</p>
        <form id="delete-form" method="POST" class="mt-6 flex justify-end gap-3">
            @csrf
            @method('DELETE')
            <button type="button" id="cancel-delete"
                class="rounded-2xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">Отмена</button>
            <button type="submit"
                class="rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow">Удалить</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('delete-modal');
    const deleteForm = document.getElementById('delete-form');
    document.querySelectorAll('.delete-order').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            deleteForm.action = `/admin/order/${id}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });
    document.getElementById('cancel-delete').addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });
</script>
@endsection
