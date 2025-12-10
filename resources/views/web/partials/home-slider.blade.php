<div id="controls-carousel" class="relative w-full px-2 mt-2" data-carousel="static">
    <div class="overflow-hidden swiper swiper_main rounded-xl">

        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
            <div class="w-full h-full bg-black swiper-slide"><img src="{{ asset('storage/'.$slider->image) }}" class="object-cover object-center w-full h-36 lg:h-80"></div>
            @endforeach
        </div>
        <div class="hidden text-white swiper-button-prev hover:text-white/80 lg:block"></div>
        <div class="hidden text-white swiper-button-next hover:text-white/80 lg:block"></div>
    </div>
</div>


<section class="grid grid-cols-4 gap-2 px-2 mt-4 sm:grid-cols-5 lg:grid-cols-6 xl:grid-cols-12 lg:gap-4">
    @foreach ($categories as $category)
    <a href="{{ route('search', ['category' => $category->id]) }}" class="flex flex-col items-center gap-2 text-center">
        <div class="flex items-center justify-center w-20 h-20 mx-auto overflow-hidden bg-white rounded-full shadow-sm ring-1 ring-gray-100 lg:w-24 lg:h-24">
            <img class="object-contain w-4/5 h-4/5 duration-200 hover:scale-105" src="{{ asset('storage/'.$category->photo) }}" alt="{{ $category->name }}">
        </div>
        <p class="w-20 text-xs text-gray-700 lg:w-24 line-clamp-2">{{ $category->name }}</p>
    </a>
    @endforeach
</section>
