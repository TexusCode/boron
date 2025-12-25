<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ $title ?? 'Boron Courier' }}</title>
    @yield('opengraph')
    @yield('styles')
    @include('global.vite')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap');

        :root {
            --courier-ink: #0f172a;
            --courier-subtle: #64748b;
            --courier-accent: #0f766e;
            --courier-accent-2: #38bdf8;
            --courier-card: rgba(255, 255, 255, 0.92);
        }

        body {
            font-family: 'Manrope', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="relative">
        <div
            class="pointer-events-none absolute inset-x-0 top-0 h-20 bg-gradient-to-br from-teal-500/20 via-sky-500/20 to-emerald-500/20">
        </div>
        <nav class="sticky top-0 z-40 backdrop-blur">
            <div class="mx-auto flex max-w-4xl items-center justify-between px-4 py-4">
                <a href="{{ route('courier.orders') }}" class="flex items-center gap-3">
                    <div
                        class="flex h-11 w-11 p-1 items-center justify-center rounded-2xl bg-white text-white shadow-lg">
                        <img src="{{ asset('favicon.png') }}" alt="">
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Courier</p>
                        <h1 class="text-lg font-semibold text-slate-900">Boron Delivery</h1>
                    </div>
                </a>
                <div class="relative">
                    <button type="button" id="courier-menu" data-dropdown-toggle="courier-dropdown"
                        class="flex items-center gap-2 rounded-2xl bg-white/80 px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-white/60">
                        <span class="hidden sm:block">{{ Auth::user()->name ?? 'Курьер' }}</span>
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-sky-500 text-sm font-bold text-white">
                            @php
                                $name = trim(Auth::user()->name ?? '');
                                $initials = 'CR';
                                if ($name !== '') {
                                    $parts = preg_split('/\s+/u', $name, -1, PREG_SPLIT_NO_EMPTY);
                                    $firstChar = mb_substr($parts[0], 0, 1);
                                    $secondChar = isset($parts[1])
                                        ? mb_substr($parts[1], 0, 1)
                                        : (mb_strlen($parts[0]) > 1
                                            ? mb_substr($parts[0], 1, 1)
                                            : '');
                                    $initials = mb_strtoupper($firstChar . $secondChar);
                                }
                            @endphp
                            {{ $initials }}
                        </span>
                    </button>
                    <div id="courier-dropdown"
                        class="absolute right-0 z-50 hidden w-56 overflow-hidden rounded-2xl border border-white/70 bg-white/95 text-sm text-slate-700 shadow-xl backdrop-blur">
                        <a href="{{ route('courier.archive') }}"
                            class="flex items-center gap-2 px-4 py-3 hover:bg-slate-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.25 6.75H3.75m16.5 0-2.25 3H6l-2.25-3m16.5 0V17.25A1.5 1.5 0 0 1 18.75 18.75H5.25A1.5 1.5 0 0 1 3.75 17.25V6.75" />
                            </svg>
                            Архив заказов
                        </a>
                        <a href="{{ route('courier.profile') }}"
                            class="flex items-center gap-2 px-4 py-3 hover:bg-slate-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm6 9H6a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4Z" />
                            </svg>
                            Настройки профиля
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="border-t border-slate-100">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex w-full items-center gap-2 px-4 py-3 text-rose-600 hover:bg-rose-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H3m6-6-6 6 6 6M21 4v16" />
                                </svg>
                                Выйти
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="mx-auto max-w-4xl px-4 pb-12 pt-6">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
    @include('global.scripts')
</body>

</html>
