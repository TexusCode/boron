@extends('web.layouts.app')
@section('content')
<section class="py-8 bg-white">
    <div class="max-w-screen-xl px-4 mx-auto">
        <div class="max-w-4xl space-y-6">
            <div>
                <p class="text-sm text-gray-500">Мы рядом, чтобы помочь</p>
                <h1 class="mt-1 text-3xl font-semibold text-gray-900">Техническая поддержка</h1>
                <p class="mt-3 text-base text-gray-700">Опишите проблему, приложите номер заказа или скриншот — мы вернемся с решением. Служба работает ежедневно с 09:00 до 22:00.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="p-5 border border-gray-200 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-900">Свяжитесь с нами</h2>
                    <ul class="mt-2 space-y-2 text-base text-gray-700">
                        <li><a class="text-primary-700 hover:underline" href="mailto:support@boron.tj">support@boron.tj</a> — вопросы по оплате, доставке, возвратам.</li>
                        <li><a class="text-primary-700 hover:underline" href="tel:+992933604040">+992 93 360 40 40</a> — срочные вопросы и подтверждение заказов.</li>
                        <li><a class="text-primary-700 hover:underline" href="https://t.me/boron_support">t.me/boron_support</a> — чат в Telegram для оперативных ответов.</li>
                    </ul>
                </div>
                <div class="p-5 border border-gray-200 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-900">Что указать в обращении</h2>
                    <ul class="mt-2 space-y-2 text-base text-gray-700 list-disc list-inside">
                        <li>Номер заказа и контактный телефон.</li>
                        <li>Краткое описание проблемы или вопроса.</li>
                        <li>Скриншоты или фото, если что-то не работает.</li>
                    </ul>
                </div>
            </div>

            <div class="p-5 border border-gray-200 rounded-2xl bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-900">Частые вопросы</h2>
                <div class="mt-3 space-y-3">
                    <details class="p-3 rounded-xl bg-white border border-gray-200">
                        <summary class="cursor-pointer text-base font-semibold text-gray-900">Где посмотреть статус заказа?</summary>
                        <p class="mt-2 text-base text-gray-700">Откройте раздел «Мои заказы» в профиле. Там есть текущий статус, состав корзины и история действий.</p>
                    </details>
                    <details class="p-3 rounded-xl bg-white border border-gray-200">
                        <summary class="cursor-pointer text-base font-semibold text-gray-900">Как отменить или изменить заказ?</summary>
                        <p class="mt-2 text-base text-gray-700">Заказы со статусом «Ожидание» можно отменить в личном кабинете. Изменения по доставке и оплате — через поддержку.</p>
                    </details>
                    <details class="p-3 rounded-xl bg-white border border-gray-200">
                        <summary class="cursor-pointer text-base font-semibold text-gray-900">Не работает код из SMS</summary>
                        <p class="mt-2 text-base text-gray-700">Проверьте правильность ввода и актуальность кода. Если не помогло — запросите новый или напишите в поддержку, мы проверим.</p>
                    </details>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
