<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
    <div class="space-y-2">
        <label for="action" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Массовое действие</label>
        <select id="action" name="action" class="w-full rounded-2xl border border-gray-200 bg-gray-50/60 px-4 py-3 text-sm font-medium text-gray-700 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Выберите действие</option>
            <option value="delete">Удалить выбранные</option>
            @if(Auth::user()->role == 'admin')
                <option value="activate">Активировать выбранные</option>
                <option value="deactivate">Деактивировать выбранные</option>
            @endif
        </select>
    </div>

    <div class="space-y-2">
        <label for="category" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Категория</label>
        <select wire:model.live="selectedCategory" id="category" name="category" class="w-full rounded-2xl border border-gray-200 bg-gray-50/60 px-4 py-3 text-sm font-medium text-gray-700 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Все категории</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="space-y-2">
        <label for="subcategory" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Подкатегория</label>
        <select id="subcategory" name="subcategory" class="w-full rounded-2xl border border-gray-200 bg-gray-50/60 px-4 py-3 text-sm font-medium text-gray-700 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Все подкатегории</option>
            @if($subcategories)
                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="space-y-2">
        <label for="status" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Статус</label>
        <select id="status" name="status" class="w-full rounded-2xl border border-gray-200 bg-gray-50/60 px-4 py-3 text-sm font-medium text-gray-700 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Любой статус</option>
            <option value="1">Активные</option>
            <option value="0">Неактивные</option>
        </select>
    </div>

    <div class="space-y-2">
        <label for="search" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Поиск</label>
        <input id="search" name="search" placeholder="Название или код..." class="w-full rounded-2xl border border-gray-200 bg-gray-50/60 px-4 py-3 text-sm font-medium text-gray-700 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div class="flex items-end">
        <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-500 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-indigo-200 transition hover:shadow-indigo-300">
            Применить
        </button>
    </div>
</div>
