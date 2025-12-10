@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Витрина</p>
                <h1 class="text-3xl font-semibold text-gray-900">Слайды на главной</h1>
                <p class="text-sm text-gray-500">Добавляйте баннеры с ссылками на акции и категории.</p>
            </div>
            <button type="button" data-modal-target="slider-modal" data-modal-toggle="slider-modal"
                class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                + Добавить слайд
            </button>
        </div>
    </header>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Список</p>
                <h2 class="text-xl font-semibold text-gray-900">Всего слайдов: {{ $sliders->count() }}</h2>
            </div>
        </div>
        <div class="mt-6 grid gap-4 md:grid-cols-2">
            @forelse ($sliders as $slider)
                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4 shadow-sm">
                    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white">
                        <img src="{{ asset('storage/'.$slider->image) }}" alt="Слайд"
                            class="h-48 w-full object-cover">
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
                        <a href="{{ $slider->link }}" target="_blank" class="text-indigo-600 hover:underline">
                            {{ $slider->link }}
                        </a>
                        <form action="{{ route('slider-del', $slider->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="rounded-full bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-500">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Слайдов пока нет.</p>
            @endforelse
        </div>
    </div>
</section>

<div id="slider-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-xl rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Слайд</p>
                <h3 class="text-lg font-semibold text-gray-900">Добавить баннер</h3>
            </div>
            <button type="button" data-modal-hide="slider-modal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <form action="{{ route('slider-add') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700">Ссылка (URL)</label>
                <input type="url" name="link" required placeholder="https://boron.tj/promo"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <label class="flex flex-col rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500">
                <span class="font-semibold text-gray-900">Изображение (1920×600)</span>
                <input type="file" name="image" class="mt-3 text-sm text-gray-500" required>
            </label>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="slider-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Добавить</button>
            </div>
        </form>
    </div>
</div>
@endsection
