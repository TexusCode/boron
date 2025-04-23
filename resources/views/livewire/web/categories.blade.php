<section class="antialiased">
    <div class="max-w-screen-xl mx-auto">
        <div class="grid gap-2 lg:grid-cols-3">
            @foreach ($categories as $category)

            <div class="hs-accordion-group">
                <div class="hs-accordion" id="hs-{{$category->id}}">
                    <div class="inline-flex items-center justify-between w-full font-semibold text-gray-800 rounded-lg hs-accordion-active:text-blue-600 gap-x-3 text-start hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none">
                        <a href="{{ route('search', ['category' => $category->id]) }}" class="flex items-center gap-2 text-sm">

                            <img src="{{ asset('storage/'.$category->photo) }}" alt="{{ $category->name }}" class="object-cover object-center w-5 h-5 rounded-lg">


                            <span>
                                {{ $category->name }}
                            </span>
                        </a>

                        @if($category->subcategories->count() > 0)
                        <button aria-expanded="false" aria-controls="hs-{{$category->id}}" class="hs-accordion-toggle">
                            <svg class="block hs-accordion-active:hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                            <svg class="hidden hs-accordion-active:block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m18 15-6-6-6 6"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                    <div id="hs-{{$category->id}}" class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="hs-{{$category->id}}">
                        <div class="grid grid-cols-1 gap-2 mt-2 ml-4">
                            @foreach ($category->subcategories as $subcategory)
                            <a href="{{ route('search', ['subcategory' => $subcategory->id]) }}" class="flex items-center">
                                <span class="text-sm font-medium text-gray-600 hover:underline">{{ $subcategory->name }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>
