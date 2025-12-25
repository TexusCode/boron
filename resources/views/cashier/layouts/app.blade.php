<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ $title ?? 'Boron Cashier' }}</title>
    @yield('opengraph')
    @yield('styles')
    @include('global.vite')
</head>

<body class="bg-slate-50 text-slate-900">
    <nav class="sticky top-0 z-40 bg-white/90 backdrop-blur shadow-sm">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4">
            <a href="{{ route('cashier.dashboard') }}" class="text-lg font-extrabold uppercase tracking-wide">
                BORON.TJ • Cashier
            </a>
            <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase">
                <a href="{{ route('cashier.orders.create') }}"
                    class="rounded-full bg-slate-900 px-4 py-2 text-white">Новый заказ</a>
                <a href="{{ route('cashier.orders.index') }}"
                    class="rounded-full border border-slate-200 px-4 py-2 text-slate-600">Заказы</a>
                <a href="{{ route('cashier.clients.index') }}"
                    class="rounded-full border border-slate-200 px-4 py-2 text-slate-600">Клиенты</a>
                <a href="{{ route('cashier.sms-templates.index') }}"
                    class="rounded-full border border-slate-200 px-4 py-2 text-slate-600">SMS шаблоны</a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="rounded-full bg-rose-50 px-4 py-2 text-xs font-semibold uppercase text-rose-600">
                    Выйти
                </button>
            </form>
        </div>
    </nav>
    <main class="mx-auto max-w-5xl px-4 py-2">
        @yield('content')
    </main>
    @yield('scripts')
    @include('global.scripts')
</body>

</html>
