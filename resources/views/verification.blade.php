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
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-center w-24 h-24 mx-auto text-white rounded-full bg-primary-700">

                        <svg class="size-16" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile-message">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M11 3h10v8h-3l-4 2v-2h-3z" />
                            <path d="M15 16v4a1 1 0 0 1 -1 1h-8a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h2" />
                            <path d="M10 18v.01" /></svg>


                    </div>

                    <h1 class="text-4xl font-bold leading-none text-center text-gray-900">
                        Подтвердите номер телефона
                    </h1>
                    <p class="text-sm text-center text-gray-600">
                        Мы отправили 6-значный код подтверждения на номер +992{{ session('phone') }}. Введите его ниже.
                    </p>
                    <form class="grid justify-center gap-2" action="{{ route('loginpost') }}" method="POST">
                        @csrf
                        <div class="mx-auto">
                            <div class="flex w-full space-x-2">
                                <div>
                                    <label for="code-1" class="sr-only">First code</label>
                                    <input type="text" autofocus maxlength="1" name="code_1" data-focus-input-init data-focus-input-next="code-2" id="code-1" class="block py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg w-9 h-9 focus:ring-primary-500 focus:border-primary-500 " required placeholder="*" />
                                </div>
                                <div>
                                    <label for="code-2" class="sr-only">Second code</label>
                                    <input type="text" maxlength="1" name="code_2" data-focus-input-init data-focus-input-prev="code-1" data-focus-input-next="code-3" id="code-2" class="block py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg w-9 h-9 focus:ring-primary-500 focus:border-primary-500 " required placeholder="*" />
                                </div>
                                <div>
                                    <label for="code-3" class="sr-only">Third code</label>
                                    <input type="text" maxlength="1" name="code_3" data-focus-input-init data-focus-input-prev="code-2" data-focus-input-next="code-4" id="code-3" class="block py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg w-9 h-9 focus:ring-primary-500 focus:border-primary-500 " required placeholder="*" />
                                </div>
                                <div>
                                    <label for="code-4" class="sr-only">Fourth code</label>
                                    <input type="text" maxlength="1" name="code_4" data-focus-input-init data-focus-input-prev="code-3" data-focus-input-next="code-5" id="code-4" class="block py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg w-9 h-9 focus:ring-primary-500 focus:border-primary-500 " required placeholder="*" />
                                </div>
                                <div>
                                    <label for="code-5" class="sr-only">Fifth code</label>
                                    <input type="text" maxlength="1" name="code_5" data-focus-input-init data-focus-input-prev="code-4" data-focus-input-next="code-6" id="code-5" class="block py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg w-9 h-9 focus:ring-primary-500 focus:border-primary-500 " required placeholder="*" />
                                </div>
                                <div>
                                    <label for="code-6" class="sr-only">Sixth code</label>
                                    <input type="text" maxlength="1" name="code_6" data-focus-input-init data-focus-input-prev="code-5" id="code-6" class="block py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg w-9 h-9 focus:ring-primary-500 focus:border-primary-500 " required placeholder="*" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full mt-4 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-base px-5 py-2.5 text-center">
                            Войти
                        </button>

                        <p class="mt-1 text-sm font-light text-center text-gray-500">
                            <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Изменит номер телефона</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        // use this simple function to automatically focus on the next input
        function focusNextInput(el, prevId, nextId) {
            if (el.value.length === 0) {
                if (prevId) {
                    document.getElementById(prevId).focus();
                }
            } else {
                if (nextId) {
                    document.getElementById(nextId).focus();
                }
            }
        }

        document.querySelectorAll('[data-focus-input-init]').forEach(function(element) {
            element.addEventListener('keyup', function() {
                const prevId = this.getAttribute('data-focus-input-prev');
                const nextId = this.getAttribute('data-focus-input-next');
                focusNextInput(this, prevId, nextId);
            });
        });

    </script>
</body>
</html>
