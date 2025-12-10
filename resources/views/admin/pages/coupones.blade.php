@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Маркетинг</p>
                <h1 class="text-3xl font-semibold text-gray-900">Купоны</h1>
                <p class="text-sm text-gray-500">Создавайте промокоды и управляйте скидками для категорий или всего каталога.</p>
            </div>
            <button type="button" data-modal-target="coupon-modal" data-modal-toggle="coupon-modal"
                class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                + Добавить купон
            </button>
        </div>
    </header>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Список</p>
                <h2 class="text-xl font-semibold text-gray-900">Активных купонов: {{ $coupones->count() }}</h2>
            </div>
        </div>
        <div class="mt-6 grid gap-4 md:grid-cols-2">
            @forelse ($coupones as $coupon)
                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs uppercase text-gray-400">Код</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $coupon->code ?: '— выдается автоматически —' }}</p>
                        </div>
                        <span class="rounded-full bg-indigo-600 px-3 py-1 text-xs font-semibold text-white">{{ $coupon->percent }}%</span>
                    </div>
                    <p class="mt-3 text-sm text-gray-600">
                        Применение:
                        @if ($coupon->scope === 'all')
                            <span class="font-semibold text-emerald-600">Все товары</span>
                        @else
                            <span class="font-semibold text-blue-600">{{ $coupon->category->name ?? 'Категория удалена' }}</span>
                        @endif
                    </p>
                    <p class="text-sm text-gray-600">
                        Авто-применение:
                        <span class="font-semibold {{ $coupon->auto_apply ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $coupon->auto_apply ? 'Включено' : 'Только по коду' }}
                        </span>
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold">
                        <form action="{{ route('delete-coupones', $coupon->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-full bg-rose-600 px-4 py-2 text-white hover:bg-rose-500">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Купоны еще не созданы.</p>
            @endforelse
        </div>
    </div>
</section>

<div id="coupon-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-xl rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Купон</p>
                <h3 class="text-lg font-semibold text-gray-900">Новый купон</h3>
                <p class="text-xs text-gray-500">Оставьте поле кода пустым, чтобы сгенерировать автоматически.</p>
            </div>
            <button type="button" data-modal-hide="coupon-modal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <form action="{{ route('add-coupones') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700">Код купона (необязательно)</label>
                <input type="text" name="code"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Например, SALE2024">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Процент скидки</label>
                <input type="number" name="percent" min="1" max="100" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Например, 15">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Где применять</label>
                <select name="scope"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="all" selected>На все товары</option>
                    <option value="category">Конкретная категория</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Категория</label>
                <select name="category_id"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Не выбрано</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                <input type="checkbox" name="auto_apply" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                Автоматически применять
            </label>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="coupon-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Добавить</button>
            </div>
        </form>
    </div>
</div>
@endsection
