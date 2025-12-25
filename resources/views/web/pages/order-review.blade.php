@extends('web.layouts.app')

@section('content')
    <section class="relative mt-5 overflow-hidden bg-gradient-to-br from-slate-50 via-white to-emerald-50 py-12">
        <div class="pointer-events-none absolute -left-24 top-12 h-56 w-56 rounded-full bg-emerald-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-20 bottom-10 h-64 w-64 rounded-full bg-indigo-200/40 blur-3xl"></div>
        <div class="mx-auto max-w-2xl px-4">
            <div class="rounded-2xl border border-slate-100 bg-white/90 p-8 shadow-xl shadow-blue-200">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Отзыв</p>
                        <h1 class="mt-2 text-2xl font-semibold text-slate-900">Оцените заказ #{{ $order->id }}</h1>
                        <p class="my-4 text-sm text-slate-500">Ваш отзыв помогает нам улучшать сервис.</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500 text-2xl">
                        ⭐
                    </div>
                </div>

                @if (session('success'))
                    <div
                        class="my-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($review)
                    <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-600">
                        <p class="text-base font-semibold text-slate-900">Спасибо! Ваш отзыв уже сохранен 🎉</p>
                        <p class="mt-2">Оценка: {{ $review->rating }} / 5</p>
                        @if ($review->comment)
                            <p class="mt-2">Комментарий: {{ $review->comment }}</p>
                        @endif
                    </div>
                @else
                    <form method="POST" action="{{ $submitUrl }}" class="mt-8 space-y-6">
                        @csrf
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Оценка</label>
                            <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-2">
                                @for ($i = 5; $i >= 1; $i--)
                                    @php
                                        $labels = [
                                            5 => ['emoji' => '😍', 'text' => 'Супер'],
                                            4 => ['emoji' => '😊', 'text' => 'Хорошо'],
                                            3 => ['emoji' => '😐', 'text' => 'Нормально'],
                                            2 => ['emoji' => '😕', 'text' => 'Плохо'],
                                            1 => ['emoji' => '😡', 'text' => 'Ужасно'],
                                        ];
                                    @endphp
                                    <label
                                        class="group relative flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-3 text-base font-semibold text-slate-700 transition hover:border-emerald-300 hover:bg-emerald-50">
                                        <input type="radio" name="rating" value="{{ $i }}"
                                            class="absolute right-4 top-4 h-4 w-4 text-emerald-600 focus:ring-emerald-500"
                                            required>
                                        <span class="text-2xl">{{ $labels[$i]['emoji'] }}</span>
                                        <span>{{ $labels[$i]['text'] }}</span>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Отзыв</label>
                            <textarea name="comment" rows="4"
                                class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-emerald-500 focus:ring-emerald-500"
                                placeholder="Напишите пару слов о доставке или сервисе..."></textarea>
                            @error('comment')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:scale-[1.01]">
                            Отправить отзыв ✨
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>
@endsection
