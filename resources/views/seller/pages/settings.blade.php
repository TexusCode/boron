@extends('seller.layouts.app')

@section('content')
    <section class="space-y-8">
        <header class="rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-500 p-6 text-white shadow-2xl">
            <div class="flex flex-wrap items-center gap-6">
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-[0.4em] text-white/70">Управление профилем</p>
                    <h1 class="text-3xl font-semibold">{{ $seller->store_name ?? 'Ваш магазин' }}</h1>
                    <p class="text-sm text-white/80">Обновляйте информацию о магазине и подключайте интеграции в одном месте.
                    </p>
                </div>
                <div class="ml-auto rounded-2xl bg-white/15 px-5 py-3 text-sm font-semibold">
                    ID продавца: {{ $seller->id ?? '—' }}
                </div>
            </div>
        </header>

        @if (session('success'))
            <div
                class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-emerald-700 shadow-md shadow-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('seller.updateSettings') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50 lg:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Информация о магазине</p>
                    <div class="mt-4 grid gap-4 md:grid-cols-2">
                        <div class="space-y-1">
                            <label for="store_name" class="text-sm font-semibold text-gray-600">Название магазина</label>
                            <input type="text" name="store_name" id="store_name" value="{{ $seller->store_name ?? '' }}"
                                required
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="space-y-1">
                            <label for="store_phone" class="text-sm font-semibold text-gray-600">Телефон магазина</label>
                            <input type="text" name="store_phone" id="store_phone"
                                value="{{ $seller->store_phone ?? '' }}" required
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="md:col-span-2 space-y-1">
                            <label for="store_description" class="text-sm font-semibold text-gray-600">Описание
                                магазина</label>
                            <textarea name="store_description" id="store_description" rows="4"
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">{{ $seller->description ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Брендинг</p>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="h-16 w-16 overflow-hidden rounded-2xl border border-dashed border-gray-200 bg-gray-50">
                                @if ($seller->logo)
                                    <img src="{{ asset('storage/' . $seller->logo) }}" alt="Логотип"
                                        class="h-full w-full object-cover">
                                @else
                                    <span
                                        class="flex h-full w-full items-center justify-center text-xs text-gray-400">Нет</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">Логотип магазина</p>
                                <p class="text-xs text-gray-500">PNG или JPG до 2 МБ.</p>
                            </div>
                        </div>
                        <label
                            class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-indigo-200 bg-indigo-50/40 px-4 py-6 text-center text-indigo-600 hover:bg-indigo-50">
                            <span class="text-sm font-semibold">Загрузить новый логотип</span>
                            <input type="file" name="store_logo" id="store_logo" class="hidden">
                        </label>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Интеграция</p>
                            <h2 class="mt-1 text-lg font-semibold text-gray-900">МойСклад</h2>
                            <p class="text-sm text-gray-500">Автоматическая синхронизация ассортимента и остатков.</p>
                        </div>
                        <label class="flex items-center gap-3 text-sm font-semibold text-gray-600">
                            <input type="hidden" name="enable_moysklad" value="0">
                            <div class="relative">
                                <input type="checkbox" name="enable_moysklad" value="1" class="sr-only peer"
                                    {{ $seller->moy_sklad ? 'checked' : '' }}>
                                <div class="h-6 w-11 rounded-full bg-gray-200 transition peer-checked:bg-indigo-600"></div>
                                <div
                                    class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-md transition peer-checked:translate-x-5">
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="mt-6 grid gap-4">
                        <div class="space-y-1">
                            <label for="moysklad_login" class="text-sm font-semibold text-gray-600">Логин МойСклад</label>
                            <input type="text" name="moysklad_login" id="moysklad_login"
                                value="{{ $seller->moysklad_login ?? '' }}"
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="space-y-1">
                            <label for="moysklad_password" class="text-sm font-semibold text-gray-600">Пароль
                                МойСклад</label>
                            <input type="password" name="moysklad_password" id="moysklad_password"
                                value="{{ $seller->moysklad_password ?? '' }}"
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col justify-between rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Подсказка</p>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">Как работать с настройками</h3>
                        <ul class="mt-4 space-y-2 text-sm text-gray-600">
                            <li>• Сохраняйте изменения после редактирования каждой секции.</li>
                            <li>• Актуализируйте описание и контакты — они отображаются на странице магазина.</li>
                            <li>• Подключите МойСклад, чтобы автоматически обновлять товары и остатки.</li>
                        </ul>
                    </div>
                    <button type="submit"
                        class="mt-6 inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-indigo-200 transition hover:shadow-indigo-300">
                        Сохранить настройки
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
