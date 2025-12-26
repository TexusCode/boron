@extends('web.layouts.app')
@section('content')
<section class="bg-slate-50">
    <div class="max-w-6xl px-4 py-10 mx-auto">
        <div class="grid items-start gap-8 lg:grid-cols-2">
            <div class="space-y-6">
                <span class="inline-flex items-center rounded-full bg-slate-900 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-white">Старт продаж</span>
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">Регистрация продавца</h1>
                    <p class="mt-3 text-base text-slate-600">
                        Добро пожаловать! Мы рады, что вы решили присоединиться к нашему сообществу продавцов.
                    </p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-600">
                        Заполните форму справа, чтобы завершить регистрацию. Укажите данные магазина, добавьте документы и примите условия.
                    </p>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            <span>Доступ к кабинету продавца сразу после проверки.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            <span>Управление товарами, заказами и аналитикой.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            <span>Поддержка и помощь в настройке.</span>
                        </li>
                    </ul>
                </div>
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-5 text-sm text-slate-600">
                    Нужные документы: логотип, патент, паспорт (лицевая и обратная сторона).
                </div>
            </div>

            <form action="{{ route('seller-register') }}" method="POST" enctype="multipart/form-data" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-lg">
                @csrf
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Данные магазина</h2>
                    <p class="mt-1 text-sm text-slate-500">Укажите название и контактный телефон.</p>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="store_name" class="block text-sm font-semibold text-slate-700">Название магазина</label>
                            <input type="text" name="store_name" id="store_name" required placeholder="Введите название магазина" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-200">
                        </div>
                        <div>
                            <label for="store_phone" class="block text-sm font-semibold text-slate-700">Телефон магазина</label>
                            <div class="mt-2 flex">
                                <span class="flex items-center rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 px-3 text-sm font-semibold text-slate-700">+992</span>
                                <input type="text" name="store_phone" id="store_phone" class="block w-full rounded-r-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-200" placeholder="931234567" minlength="9" maxlength="9" required>
                            </div>
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-semibold text-slate-700">Описание</label>
                            <textarea name="description" id="description" rows="4" placeholder="Введите краткое описание" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-200"></textarea>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <h2 class="text-lg font-semibold text-slate-900">Документы</h2>
                    <p class="mt-1 text-sm text-slate-500">Загрузите нужные файлы одним форматом.</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="logo" class="block text-sm font-semibold text-slate-700">Логотип магазина</label>
                            <input type="file" name="logo" id="logo" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-200" {{ Auth::check() && Auth::user()->role == 'admin' ? '' : 'required' }}>
                        </div>
                        <div>
                            <label for="patent" class="block text-sm font-semibold text-slate-700">Документ патента</label>
                            <input type="file" name="patent" id="patent" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-200" {{ Auth::check() && Auth::user()->role == 'admin' ? '' : 'required' }}>
                        </div>
                        <div>
                            <label for="passport_front" class="block text-sm font-semibold text-slate-700">Паспорт (лицевая сторона)</label>
                            <input type="file" name="passport_front" id="passport_front" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-200" {{ Auth::check() && Auth::user()->role == 'admin' ? '' : 'required' }}>
                        </div>
                        <div>
                            <label for="passport_back" class="block text-sm font-semibold text-slate-700">Паспорт (обратная сторона)</label>
                            <input type="file" name="passport_back" id="passport_back" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-200" {{ Auth::check() && Auth::user()->role == 'admin' ? '' : 'required' }}>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <label class="flex items-start gap-3 text-sm text-slate-600" for="terms">
                        <input type="checkbox" name="terms" required id="terms" class="mt-1 h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                        <span>Я согласен с условиями использования сервиса.</span>
                    </label>
                </div>

                <button type="submit" class="w-full rounded-xl bg-slate-900 px-6 py-3 text-sm font-semibold uppercase tracking-widest text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300">
                    Зарегистрироваться
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
