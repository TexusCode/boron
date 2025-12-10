@extends('seller.layouts.app')

@section('content')
<section class="space-y-8">
    <header class="rounded-3xl bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-700 px-8 py-10 text-white shadow-2xl">
        <p class="text-xs uppercase tracking-[0.4em] text-white/70">Интеграция</p>
        <h1 class="mt-2 text-3xl font-semibold">Настройки МойСклад</h1>
        <p class="mt-2 max-w-3xl text-sm text-white/85">
            Используйте действия ниже, чтобы синхронизировать каталог и остатки с вашим аккаунтом МойСклад. Все операции
            выполняются в фоне, поэтому вы можете продолжать работу в панели.
        </p>
    </header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-blue-100 bg-white p-6 shadow-lg shadow-blue-50">
            <div class="flex items-center justify-between text-blue-600">
                <div class="text-sm font-semibold uppercase tracking-wide">Полная синхронизация</div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-xl">↻</span>
            </div>
            <p class="mt-3 text-sm text-gray-600">Загрузить все товары из МойСклад, создавая их в каталоге продавца.</p>
            <form action="{{ route('moyskladbigupdate') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-500 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-blue-200 transition hover:shadow-blue-300">
                    Синхронизировать товары
                </button>
            </form>
        </div>

        <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-lg shadow-emerald-50">
            <div class="flex items-center justify-between text-emerald-600">
                <div class="text-sm font-semibold uppercase tracking-wide">Обновление карточек</div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-xl">✎</span>
            </div>
            <p class="mt-3 text-sm text-gray-600">Обновить названия, описания, цены и изображения уже импортированных товаров.</p>
            <form action="{{ route('moyskladbigupdate') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-emerald-500 to-green-500 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-200 transition hover:shadow-emerald-300">
                    Обновить данные
                </button>
            </form>
        </div>

        <div class="rounded-3xl border border-purple-100 bg-white p-6 shadow-lg shadow-purple-50">
            <div class="flex items-center justify-between text-purple-600">
                <div class="text-sm font-semibold uppercase tracking-wide">Остатки и количество</div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-purple-50 text-xl">📦</span>
            </div>
            <p class="mt-3 text-sm text-gray-600">Синхронизировать только наличие и остатки по каждому SKU.</p>
            <form action="{{ route('updateStockQuantities') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-purple-500 to-fuchsia-500 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-purple-200 transition hover:shadow-purple-300">
                    Обновить остатки
                </button>
            </form>
        </div>
    </div>

    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Статус операции</p>
        <p class="mt-2 text-sm text-gray-600">
            После запуска процесса вы получите уведомление, когда синхронизация завершится. Следите за логами очередей,
            если processing занимает больше времени обычного.
        </p>
    </div>
</section>
@endsection
