@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Команда</p>
                <h1 class="text-3xl font-semibold text-gray-900">Сотрудники</h1>
                <p class="text-sm text-gray-500">Управляйте доступом, ролями и контактами персонала.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('add-empliyone') }}" class="rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                    Полная регистрация
                </a>
                <button type="button" data-modal-target="employee-modal" data-modal-toggle="employee-modal"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                    + Быстро добавить
                </button>
            </div>
        </div>
    </header>

    <div class="rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Имя</th>
                        <th class="px-5 py-3 text-left">Телефон</th>
                        <th class="px-5 py-3 text-left">Роль</th>
                        <th class="px-5 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($employees as $employee)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $employee->name ?? 'Без имени' }}</td>
                            <td class="px-5 py-4">+992 {{ $employee->phone }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                    {{ ucfirst($employee->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('add-empliyone',$employee->phone) }}"
                                        class="inline-flex items-center rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('delempliyonepost', $employee->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center rounded-full bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-500">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<div id="employee-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Сотрудник</p>
                <h3 class="text-lg font-semibold text-gray-900">Быстро добавить</h3>
            </div>
            <button type="button" data-modal-hide="employee-modal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <form action="{{ route('add-empliyone-post') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700">Имя</label>
                <input type="text" name="name" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Телефон</label>
                <input type="text" name="phone" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Роль</label>
                <select name="role" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Выберите роль</option>
                    <option value="admin">Администратор</option>
                    <option value="manager">Менеджер</option>
                    <option value="deliver">Доставщик</option>
                    <option value="cashier">Кассир</option>
                    <option value="staff">Сотрудник</option>
                </select>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="employee-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Добавить</button>
            </div>
        </form>
    </div>
</div>
@endsection
