@extends('web.layouts.app')
@section('content')
<section class="py-8 bg-white">
    <div class="max-w-screen-xl px-4 mx-auto">
        <div class="max-w-5xl space-y-6">
            <div>
                <p class="text-sm text-gray-500">Обновлено: {{ now()->format('d.m.Y') }}</p>
                <h1 class="mt-1 text-3xl font-semibold text-gray-900">Политика использования</h1>
                <p class="mt-3 text-base text-gray-700">Эта страница описывает, как работает маркетплейс Boron, какие данные мы собираем и как защищаем вашу учетную запись.</p>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="p-5 border border-gray-200 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-900">1. Ответственное использование</h2>
                    <ul class="mt-2 space-y-2 text-base text-gray-700 list-disc list-inside">
                        <li>Используйте сервис только для законных покупок и продаж.</li>
                        <li>Не создавайте несколько аккаунтов для обхода ограничений.</li>
                        <li>Соблюдайте правила продавцов и описывайте товары честно.</li>
                    </ul>
                </div>
                <div class="p-5 border border-gray-200 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-900">2. Персональные данные</h2>
                    <ul class="mt-2 space-y-2 text-base text-gray-700 list-disc list-inside">
                        <li>Мы храним только необходимые данные для оформления заказов и доставки.</li>
                        <li>Телефон и имя используются для связи по заказам и поддержки.</li>
                        <li>Доступ к аккаунту защищен одноразовыми кодами и контролем активности.</li>
                    </ul>
                </div>
                <div class="p-5 border border-gray-200 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-900">3. Заказы и оплата</h2>
                    <ul class="mt-2 space-y-2 text-base text-gray-700 list-disc list-inside">
                        <li>Статусы заказа видны в вашем профиле в разделе «Мои заказы».</li>
                        <li>Вы можете отменить заказ со статусом «Ожидание» прямо в кабинете.</li>
                        <li>Возвраты и споры рассматриваются совместно с продавцом и поддержкой.</li>
                    </ul>
                </div>
                <div class="p-5 border border-gray-200 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-900">4. Контент и отзывы</h2>
                    <ul class="mt-2 space-y-2 text-base text-gray-700 list-disc list-inside">
                        <li>Отзывы должны быть честными, без ненормативной лексики и оскорблений.</li>
                        <li>Запрещено публиковать ссылки на сторонние магазины или спам.</li>
                        <li>Мы можем скрыть или удалить контент, нарушающий правила.</li>
                    </ul>
                </div>
            </div>
            <div class="p-5 border border-gray-200 rounded-2xl">
                <h2 class="text-xl font-semibold text-gray-900">5. Безопасность</h2>
                <p class="mt-2 text-base text-gray-700">Не передавайте коды подтверждения третьим лицам. Если заметили подозрительную активность, смените пароль/телефон и сообщите в поддержку.</p>
                <div class="mt-4 flex flex-wrap gap-3 text-sm text-gray-700">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-50 text-primary-800 border border-primary-100">Никогда не сообщайте SMS-коды</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-800 border border-gray-200">Проверяйте адрес сайта: boron.tj</span>
                </div>
            </div>
            <div class="p-5 border border-gray-200 rounded-2xl bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-900">Связь и изменения</h2>
                <p class="mt-2 text-base text-gray-700">Если у вас есть вопросы по политике использования, напишите нам — мы ответим и обновим материалы при необходимости.</p>
                <div class="mt-3 flex flex-col gap-1 text-base text-gray-800">
                    <a class="text-primary-700 hover:underline" href="mailto:support@boron.tj">support@boron.tj</a>
                    <a class="text-primary-700 hover:underline" href="tel:+992933604040">+992 93 360 40 40</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
