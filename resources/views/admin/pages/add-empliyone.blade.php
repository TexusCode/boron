@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Команда</p>
                <h1 class="text-3xl font-semibold text-gray-900">{{ $employee ? 'Редактировать' : 'Добавить' }} сотрудника</h1>
                <p class="text-sm text-gray-500">Заполните форму, чтобы предоставить доступ сотруднику к панели.</p>
            </div>
            <a href="{{ route('empliyones') }}"
                class="inline-flex items-center rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                ← Вернуться к списку
            </a>
        </div>
    </header>

    <form action="{{ route('add-empliyone-post') }}" method="POST" class="rounded-3xl bg-white p-6 shadow-sm space-y-4 max-w-3xl">
        @csrf
        <input type="hidden" name="employee_id" value="{{ $employee->id ?? '' }}">
        <div>
            <label class="text-sm font-semibold text-gray-700">Имя</label>
            <input type="text" name="name" value="{{ $employee->name ?? '' }}" required
                class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label class="text-sm font-semibold text-gray-700">Телефон</label>
            <input type="text" name="phone" value="{{ $employee->phone ?? request('phone') }}" required
                class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label class="text-sm font-semibold text-gray-700">Роль</label>
            <select name="role" required
                class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Выберите роль</option>
                <option value="admin" @selected(isset($employee) && $employee->role == 'admin')>Администратор</option>
                <option value="manager" @selected(isset($employee) && $employee->role == 'manager')>Менеджер</option>
                <option value="deliver" @selected(isset($employee) && $employee->role == 'deliver')>Доставщик</option>
                <option value="cashier" @selected(isset($employee) && $employee->role == 'cashier')>Кассир</option>
                <option value="staff" @selected(isset($employee) && $employee->role == 'staff')>Сотрудник</option>
            </select>
        </div>
        <div class="flex justify-end gap-3">
            <a href="{{ route('empliyones') }}" class="rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                Отмена
            </a>
            <button type="submit"
                class="rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                {{ $employee ? 'Сохранить' : 'Пригласить сотрудника' }}
            </button>
        </div>
    </form>
</section>
@endsection
