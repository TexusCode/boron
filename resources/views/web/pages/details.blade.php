@extends('web.layouts.app')
@section('content')
<div class="whatsapp-button-wrapper">
  <a href="https://wa.me/+992100604040?text=Салом! Артикул: {{$product->code}}. Я заинтересован на этот товар https://boron.tj/details/{{$product->id}}" class="whatsapp-button" aria-label="Chat on WhatsApp">
    <div class="notification-badge-wrapper">
      <div class="notification-badge">
        <span class="ping"></span>
        <span class="badge-text">1</span>
      </div>
    </div>

    <svg
      viewBox="0 0 16 16"
      class="whatsapp-icon"
      fill="currentColor"
      height="24"
      width="24"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"
      ></path>
    </svg>

    <span class="pulse-border"></span>

    <div class="tooltip">
      <div class="tooltip-text">Есть вопросы? Напишите нам!</div>
      <div class="tooltip-arrow"></div>
    </div>
  </a>
</div>

<section class="py-4 antialiased bg-white">
    <div class="max-w-screen-xl px-2 mx-auto 2xl:px-0">
        <div class="lg:flex lg:items-start lg:gap-8">
            <div class="lg:w-full lg:max-w-xl">
                <div id="controls-carousel" class="relative w-full" data-carousel="static">
                    <div class="overflow-hidden swiper swiper_main rounded-xl">
                        <div class="swiper-wrapper" id="lightgallery">
                            <!-- Главное изображение продукта -->
                            <a href="{{asset('storage/'.$product->miniature) }}" class="w-full h-full bg-black swiper-slide aspect-h-5 lg:aspect-h-4 aspect-w-5">

                                <img src="{{asset('storage/'.$product->miniature) }}" class="object-cover object-center w-full h-full thumbnail" loading="lazy">

                            </a>

                            <!-- Остальные фотографии продукта -->
                            @foreach ($product->otherphotos as $photo)
                            <a href="{{asset('storage/'.$photo->photo) }}" class="w-full h-full bg-black swiper-slide aspect-h-5 lg:aspect-h-4 aspect-w-5">

                                <img src="{{asset('storage/'.$photo->photo) }}" class="object-cover object-center w-full h-full thumbnail" loading="lazy">


                            </a>
                            @endforeach
                        </div>
                        <div class="text-white swiper-button-prev hover:text-white/80"></div>
                        <div class="text-white swiper-button-next hover:text-white/80"></div>
                    </div>
                </div>


            </div>
            <div class="mt-6 space-y-4 md:min-w-96 sm:mt-8 lg:mt-0">
                <h1 class="text-2xl font-semibold leading-none text-gray-900">{{ $product->name }}</h1>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        @if($product->discount)
                        <div class="flex items-center gap-2">
                            <p class="text-xl font-bold text-gray-900">
                                <strike> {{ $product->price}}c </strike>
                            </p>
                            <span class="me-2 rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300"> -{{ round(($product->price - $product->discount)*100/$product->price) }}% </span>

                        </div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $product->discount }}c</p>
                        @else
                        <p class="text-3xl font-extrabold text-gray-900">{{ $product->price }}c</p>
                        @endif
                    </div>
                    <ul class="space-y-1 text-sm font-medium shrink-0">
                        @if($product->stock > 0)
                        <li class="flex items-center gap-1 text-green-600 dark:text-green-400">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z" />
                            </svg>
                            В наличии
                        </li>
                        @else
                        <li class="flex items-center gap-1 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z" />
                            </svg>
                            Нет в наличии
                        </li>
                        @endif
                        @if($product->stock > 0)
                        <li class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                            </svg>
                            Доставка: <span class="font-bold"> @switch($product->delivery)
                                @case(1)
                                Сегодня
                                @break
                                @case(2)
                                Завтра
                                @break
                                @default
                                Через {{ $product->delivery }} дня
                                @endswitch
                            </span>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="max-h-full px-3 border border-gray-100 rounded-lg bg-gray-50">
                    <div class="divide-y divide-gray-200 ">
                        <dl class="flex items-center justify-between gap-4 py-2">
                            <dt class="text-sm font-medium text-gray-900">Артикул</dt>
                            <dd class="text-sm font-normal text-gray-500">{{ $product->code }}</dd>
                        </dl>
                        <dl class="flex items-center justify-between gap-4 py-2">
                            <dt class="text-sm font-medium text-gray-900">В наличии</dt>
                            <dd class="text-sm font-normal text-gray-500"> {{ $product->stock }}шт</dd>

                        </dl>
                        <dl class="flex items-center justify-between gap-4 py-2">
                            <dt class="text-sm font-medium text-gray-900">Продано</dt>
                            <dd class="text-sm font-normal text-gray-500">{{ $product->sell}}шт</dd>

                        </dl>
                        <dl class="flex items-center justify-between gap-4 py-2">
                            <dt class="text-sm font-medium text-gray-900">Рассрочка</dt>
                            <dd class="text-sm font-normal text-gray-500">есть</dd>
                        </dl>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <label class="relative flex">
                        <div class="relative flex-1 space-y-0.5 overflow-hidden rounded-lg border border-green-200 p-2 peer-checked:border-primary-700 ">
                            <p class="text-sm font-medium leading-none text-gray-900">@if($product->discount) {{ round($product->discount/3) }} @else {{ round($product->price/3) }} @endif c/3м <span class="font-bold text-green-500">0%</span></p>
                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400">Рассрочка с картой <span class="text-red-500">"Салом"</span> от <a href="" class="font-bold text-green-400">Alif Bank</a></p>
                        </div>
                    </label>
                    <label class="relative flex">
                        <div class="relative flex-1 space-y-0.5 overflow-hidden rounded-lg border border-green-200 p-2 peer-checked:border-primary-700 ">
                            <p class="text-sm font-medium leading-none text-gray-900">@if($product->discount) {{ round(($product->discount*1.1)/6) }} @else {{ round(($product->price*1.1)/6) }} @endif c/6м <span class="font-bold text-green-500">10%</span></p>
                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400">Рассрочка с картой <span class="text-red-500">"Салом"</span> от <a href="" class="font-bold text-green-400">Alif Bank</a></p>
                        </div>
                    </label>
                    <label class="relative flex">
                        <div class="relative flex-1 space-y-0.5 overflow-hidden rounded-lg border border-green-200 p-2 peer-checked:border-primary-700 ">
                            <p class="text-sm font-medium leading-none text-gray-900">@if($product->discount) {{ round(($product->dicount*1.2)/12) }} @else {{ round(($product->price*1.2)/12) }} @endif c/12м <span class="font-bold text-green-500">20%</span></p>
                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400">
                                Рассрочка с картой <span class="text-red-500">"Салом"</span> от <a href="" class="font-bold text-green-400">Alif Bank</a></p>
                        </div>
                    </label>
                </div>
                <div class="hidden lg:block">
                    @livewire('produuct-details-add-to-cart-favorie',['id'=>$product->id])
                </div>
                <div class="fixed left-0 z-50 block w-full px-2 pt-1 bg-white border-t-2 h-14 bottom-16 lg:hidden">
                    @livewire('produuct-details-add-to-cart-favorie',['id'=>$product->id])
                </div>



                <hr class="border-gray-200 dark:border-gray-700" />

                {{-- <div>
                    <p class="mb-2 text-sm font-normal text-gray-500 dark:text-gray-400">
                        Sold and shipped by
                        <span class="font-semibold text-gray-900">Flowbite</span>
                    </p>

                    <div class="flex items-center gap-2 mb-2">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                            </svg>
                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                            </svg>
                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                            </svg>
                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                            </svg>
                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium leading-none text-gray-500 dark:text-gray-400">(5.0)</p>
                        <a href="#" class="text-sm font-medium leading-none text-gray-900 underline hover:no-underline"> 345 Reviews </a>
                    </div>

                    <a href="#" title="" class="text-sm font-medium underline text-primary-700 hover:no-underline dark:text-primary-500"> View seller information </a>
                </div> --}}
            </div>

            <div class="grid grid-cols-1 gap-6 mt-6 md:min-w-72 shrink-0 sm:mt-8 sm:grid-cols-2 lg:mt-0 lg:w-48 lg:grid-cols-1 lg:pr-8">

                <div class="space-y-2">
                    <div class="p-2 space-y-1 border rounded-lg border-primary-200 bg-primary-50">

                        @if($product->seller->isverified)
                        <div class="flex items-center justify-center gap-2 py-1 mb-2 text-green-500 bg-green-100 border-2 border-green-300 rounded-md">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.644 3.066a1 1 0 0 1 .712 0l7 2.666A1 1 0 0 1 20 6.68a17.694 17.694 0 0 1-2.023 7.98 17.406 17.406 0 0 1-5.402 6.158 1 1 0 0 1-1.15 0 17.405 17.405 0 0 1-5.403-6.157A17.695 17.695 0 0 1 4 6.68a1 1 0 0 1 .644-.949l7-2.666Zm4.014 7.187a1 1 0 0 0-1.316-1.506l-3.296 2.884-.839-.838a1 1 0 0 0-1.414 1.414l1.5 1.5a1 1 0 0 0 1.366.046l4-3.5Z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-bold uppercase"> Надёжный продавец</span>

                        </div>
                        @endif
                        <div class="grid grid-cols-4 gap-2">
                            <div class="p-2">
                                <img src="{{ asset('storage/'.$product->seller->logo) }}" alt="" class="object-contain w-full h-full">
                            </div>
                            <div class="col-span-3">
                                <h1 class="mb-2 font-bold leading-none uppercase line-clamp-1 text-primary-600">{{ $product->seller->store_name }}</h1>
                                <div class="grid grid-cols-2 px-2 py-1 text-sm rounded-lg font-me bg-primary-100 text-primary-600">

                                    <div class="flex flex-col items-center justify-center">
                                        <p>Товары</p>
                                        <span>{{ $product->seller->products->count() }}шт</span>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <p>Продажи</p>
                                        <span>{{ $product->seller->suborders->sum('count') }}шт</span>
                                    </div>
                                </div>
                            </div>
                            @if($product->seller->description)
                            <div class="text-sm col-span-full">
                                {{ $product->seller->description }}
                            </div>
                            @endif
                            <a href="{{ route('page-seller',$product->seller->id) }}" class="flex justify-center p-2 font-semibold rounded-md bg-primary-100 text-primary-600 hover:underline lg:text-sm col-span-full">

                                Перейти на страницу магазина
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="mb-2 text-sm font-semibold text-gray-900">Преимущества</p>
                    <ul class="mb-2 space-y-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                            Возврат в течение 3 дней
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                            Возможность отмены заказа
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                            Быстрая доставка по всему РТ

                        </li>
                    </ul>
                </div>


            </div>
        </div>
    </div>
</section>
@if($product->description !== null)
<section class="bg-white">
    <div class="max-w-screen-xl px-2 mx-auto mb-4">
        <div class="max-w-screen-xl text-gray-500 sm:text-lg dark:text-gray-400">
            <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900">Описание товара</h2>
            <p class="font-medium">
                {{ $product->description }}
            </p>
        </div>
    </div>
</section>
@endif
<section class="bg-white">
    <div class="max-w-screen-xl px-2 mx-auto mb-4">
        <div class="max-w-screen-xl text-gray-500 sm:text-lg dark:text-gray-400">
            <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900">Другие товары</h2>
            <div class="grid grid-cols-2 gap-1 mb-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                @foreach ($otherProducts as $product)
                @include('web.partials.product-card')
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/lightgallery@2.6.0/css/lightgallery.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.6.0/lightgallery.min.js"></script>

<style>
    .whatsapp-button-wrapper {
  position: fixed;
  bottom: 12rem; /* bottom-14 */
  right: 5rem; /* right-5 */
  z-index: 99999;
}

.whatsapp-button {
  position: absolute;
  background-color: #22c55e; /* green-500 */
  color: white;
  width: 3.5rem; /* w-14 */
  height: 3.5rem; /* h-14 */
  border-radius: 9999px; /* full */
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1); /* shadow-lg */
  transition: all 0.3s ease-out;
  z-index: 50;
  border: none;
  cursor: pointer;
}

.whatsapp-button:hover {
  background-color: #16a34a; /* green-600 */
  transform: scale(1.05);
}

.whatsapp-button:active {
  transform: scale(0.95);
}

.notification-badge-wrapper {
  position: absolute;
  top: -0.25rem;
  right: -0.25rem;
  z-index: 10;
}

.notification-badge {
  display: flex;
  width: 1.5rem;
  height: 1.5rem;
  align-items: center;
  justify-content: center;
  position: relative;
}

.ping {
  position: absolute;
  height: 100%;
  width: 100%;
  background-color: #f87171; /* red-400 */
  border-radius: 9999px;
  opacity: 0.75;
  animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

@keyframes ping {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  75%, 100% {
    transform: scale(2);
    opacity: 0;
  }
}

.badge-text {
  position: relative;
  display: inline-flex;
  height: 1.25rem;
  width: 1.25rem;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: bold;
  color: white;
  background-color: #ef4444; /* red-500 */
  border-radius: 9999px;
}

.whatsapp-icon {
  width: 1.75rem; /* w-7 */
  height: 1.75rem; /* h-7 */
}

.pulse-border {
  position: absolute;
  inset: 0;
  border-radius: 9999px;
  border: 4px solid rgba(255, 255, 255, 0.3);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  100% {
    transform: scale(1.5);
    opacity: 0;
  }
}

.tooltip {
  position: absolute;
  right: 100%;
  margin-right: 0.75rem; /* mr-3 */
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s;
  white-space: nowrap;
}

.whatsapp-button:hover .tooltip {
  opacity: 1;
  visibility: visible;
}

.tooltip-text {
  background-color: #1f2937; /* gray-800 */
  color: white;
  font-size: 0.875rem;
  padding: 0.25rem 0.75rem;
  border-radius: 0.25rem;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.tooltip-arrow {
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateX(50%) translateY(-50%) rotate(45deg);
  width: 0.5rem;
  height: 0.5rem;
  background-color: #1f2937; /* gray-800 */
}

</style>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.6.0/plugins/zoom/lg-zoom.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.6.0/plugins/fullscreen/lg-fullscreen.min.js"></script>
<script>
    const swiper = new Swiper('.swiper_main', {
        loop: true
        , autoplay: {
            delay: 2000
        , }
        , navigation: {
            nextEl: ".swiper-button-next"
            , prevEl: ".swiper-button-prev"
        , }
    , })

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        lightGallery(document.getElementById('lightgallery'), {
            plugins: [lgZoom, lgFullscreen]
            , speed: 500
            , zoom: true
            , fullscreen: true
        });
    });

</script>
@endsection
@section('opengraph')
<!-- Основные Open Graph теги -->
<meta property="og:title" content="{{ $title ?? 'Boron Marketplace' }}">
<meta property="og:description" content="{{ $product->description ?? '' }}">

{{-- <meta property="og:image" content="{{asset('storage/'.$product->miniature) }}"> --}}


<!-- Дополнительные теги для Open Graph -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="www.boron.tj">

@endsection
