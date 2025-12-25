@extends($layout ?? 'cashier.layouts.app')

@php($routePrefix = $routePrefix ?? 'cashier.')

@section('content')
<section class="space-y-6">
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">SMS</p>
        <h1 class="mt-2 text-2xl font-semibold text-slate-900">Шаблоны сообщений</h1>
        <p class="mt-2 text-sm text-slate-500">Создайте шаблоны для отправки клиентам.</p>
    </header>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Новый шаблон</h2>
            <form method="POST" action="{{ route($routePrefix . 'sms-templates.store') }}" class="mt-4 space-y-3">
                @csrf
                <input name="title" placeholder="Название"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm" required>
                <textarea name="body" rows="4" placeholder="Текст SMS"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm" required></textarea>
                <p class="text-xs text-slate-400">Переменные: {order_id}, {client_name}, {total}, {status}</p>
                <button type="submit" class="w-full rounded-2xl bg-slate-900 px-4 py-2 text-xs font-semibold uppercase text-white">Сохранить</button>
            </form>
        </div>

        <div class="space-y-4">
            @foreach ($templates as $template)
                <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <form method="POST" action="{{ route($routePrefix . 'sms-templates.update', $template) }}" class="space-y-3">
                        @csrf
                        @method('PATCH')
                        <input name="title" value="{{ $template->title }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm" required>
                        <textarea name="body" rows="3"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm" required>{{ $template->body }}</textarea>
                        <button type="submit" class="rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase text-white">Обновить</button>
                    </form>
                    <form method="POST" action="{{ route($routePrefix . 'sms-templates.destroy', $template) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-full border border-rose-200 px-4 py-2 text-xs font-semibold uppercase text-rose-600">Удалить</button>
                    </form>
                </div>
            @endforeach

            @if ($templates->isEmpty())
                <div class="rounded-3xl bg-white p-6 text-sm text-slate-500 shadow-sm">
                    Шаблонов пока нет.
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
