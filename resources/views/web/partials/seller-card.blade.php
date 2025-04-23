<div class="p-4 space-y-4 border rounded-lg shadow-lg border-primary-200 bg-primary-50">

    @if($seller->isverified)
    <div class="flex items-center justify-center gap-2 py-2 mb-4 text-green-600 bg-green-200 border-2 border-green-400 rounded-md shadow-sm">
        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M11.644 3.066a1 1 0 0 1 .712 0l7 2.666A1 1 0 0 1 20 6.68a17.694 17.694 0 0 1-2.023 7.98 17.406 17.406 0 0 1-5.402 6.158 1 1 0 0 1-1.15 0 17.405 17.405 0 0 1-5.403-6.157A17.695 17.695 0 0 1 4 6.68a1 1 0 0 1 .644-.949l7-2.666Zm4.014 7.187a1 1 0 0 0-1.316-1.506l-3.296 2.884-.839-.838a1 1 0 0 0-1.414 1.414l1.5 1.5a1 1 0 0 0 1.366.046l4-3.5Z" clip-rule="evenodd" />
        </svg>
        <span class="text-sm font-semibold uppercase">Надёжный продавец</span>
    </div>
    @endif

    <div class="grid grid-cols-4 gap-4">
        <div class="p-2">
            <img src="{{ asset('storage/'.$seller->logo) }}" alt="Логотип магазина" class="object-contain w-full h-full rounded-md shadow-sm">


        </div>
        <div class="col-span-3">
            <h1 class="mb-2 text-xl font-bold leading-none uppercase text-primary-600 line-clamp-1">{{ $seller->store_name }}</h1>
            <div class="grid grid-cols-2 px-2 py-1 text-sm font-medium rounded-lg shadow-inner bg-primary-100 text-primary-600">

                <div class="flex flex-col items-center justify-center">
                    <p class="text-gray-700">Товары</p>
                    <span class="font-bold">{{ $seller->products->count() }} шт</span>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="text-gray-700">Продажи</p>
                    <span class="font-bold">{{ $seller->suborders->sum('count') }} шт</span>
                </div>
            </div>
        </div>

        @if($seller->description)
        <div class="mt-2 text-sm text-gray-700 col-span-full">
            {{ $seller->description }}
        </div>
        @endif

        <a href="{{ route('page-seller', $seller->id) }}" class="flex justify-center p-3 font-semibold transition duration-300 rounded-md bg-primary-100 text-primary-600 hover:bg-primary-200 hover:underline lg:text-sm col-span-full">
            Перейти на страницу магазина
        </a>
    </div>
</div>
