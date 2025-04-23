    <div class="flex flex-col gap-4 lg:flex-row">
        <div class="w-full">
            <label for="action" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Выберите действия</label>
            <select id="action" name="action" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Выберите действия</option>
                <option value="delete">Удалить выбранные</option>
                @if(Auth::user()->role == 'admin')
                <option value="activate">Активироват выбранные</option>
                <option value="deactivate">Деактивировать выбранные</option>
                @endif

            </select>
        </div>
        <div class="w-full">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Категория</label>
            <select wire:model.live="selectedCategory" id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Выберите категория</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>



                @endforeach
            </select>
        </div>
        <div class="w-full">
            <label for="subcategory" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Под категория</label>
            <select id="subcategory" name="subcategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Выберите под категория</option>
                @if($subcategories)
                @foreach ($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="w-full">
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Статус товар</label>
            <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Выберите статус товара</option>
                <option value="1">Активные</option>
                <option value="0">Не активные</option>
            </select>
        </div>
        <div class="w-full">
            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Искать товар</label>
            <input id="search" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>

        <div class="flex items-end w-full">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 w-full">Обновить</button>
        </div>
    </div>
