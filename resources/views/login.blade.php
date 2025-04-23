<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('global.vite')
</head>
<body>
    <section class="bg-gradient-to-b from-primary-500 to-primary-700 bg-blend-multiply bg-opacity-60">

        <div class="flex flex-col items-center justify-center h-screen px-6 py-8 mx-auto pt:mt-0">
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800">
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-center w-24 h-24 mx-auto text-white rounded-full bg-primary-700">
                        <svg class="size-16" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" />
                            <path d="M11 4h2" />
                            <path d="M12 17v.01" /></svg>

                    </div>
                    <h1 class="text-4xl font-bold leading-none text-center text-gray-900">
                        Введите номер телефона
                    </h1>
                    <p class="text-sm text-center text-gray-600">
                        Мы отправим код на ваш номер телефона в СМС для подтверждения, что вы реальный человек и никто не пытается зарегистрироваться за вас.

                    </p>

                    <form class="space-y-4" action="{{ route('verificationpost') }}" method="POST">
                        @csrf
                        <div class="flex">
                            <span class="bg-gray-50 border border-r-0 border-gray-300 text-xl text-gray-900 rounded-l-lg  block w-min p-2.5">+992</span>

                            <input type="text" name="phone" class="bg-gray-50 text-xl border border-gray-300 text-gray-900 rounded-r-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="931234567" minlength="9" maxlength="9" required>
                        </div>
                        <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-base px-5 py-2.5 text-center">
                            Подтвердить
                        </button>


                        <p class="text-sm font-light text-center text-gray-500">
                            <a href="{{ route('home') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Перейти на главную страницу</a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
