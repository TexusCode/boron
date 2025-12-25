@extends('cashier.layouts.app')

@section('content')
<section class="space-y-6">
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Клиенты</p>
        <h1 class="mt-2 text-2xl font-semibold text-slate-900">Добавить клиента</h1>
        <p class="mt-2 text-sm text-slate-500">Если номер уже есть, имя обновится.</p>
    </header>

    <form method="POST" action="{{ route('cashier.clients.store') }}" class="rounded-3xl bg-white p-6 shadow-sm">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Имя</label>
                <input name="name" required
                    class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Телефон</label>
                <input name="phone" required
                    class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
            </div>
        </div>
        <button type="submit"
            class="mt-4 rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold uppercase text-white">
            Сохранить клиента
        </button>
    </form>
</section>
@endsection
