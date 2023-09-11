<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monda:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-slate-100 m-0  overflow-x-hidden">
    @if (session('success'))
        <p class="text-green-500">{{ session('success') }}</p>
    @endif
    <div class="bg-white">
        <header class="flex shadow-sm py-5 mx-10 md:mx-auto max-w-[1080px] justify-between items-center">
            <img src="{{ asset('images/jetorbit-logo.png') }}" class="mix-blend-multiply w-28" alt="">

            @if (Auth::check())
                <div x-data="{ open: false }" class="relative z-20">
                    <div class="flex items-center">
                        <p x-on:click="open = ! open" class="cursor-pointer">Hello, <strong> Pengguna </strong></p>
                        <img src="{{ asset('assets/chevron.svg') }}" width="20" class='opacity-50'
                            x-bind:class="open ? 'rotate-180' : ''" alt="arrow down">
                    </div>

                    <span x-show="open" x-transition
                        class="bg-white shadow-md  border-[1px] border-slate-100 absolute w-full mt-4 rounded-md">
                        <ul class="py-3 px-2 text-center">
                            <li class="p-1 mb-3 rounded flex cursor-pointer items-center hover:bg-slate-200 px-1"> <img
                                    src="{{ asset('assets/person.svg') }}" width="24" alt="person">
                                <a href="#" class="px-1">Profile</a>
                            </li>
                            <li class="flex p-1 rounded hover:bg-slate-200 items-center cursor-pointer"> <img
                                    src="{{ asset('assets/logout.svg') }}" alt="log out">
                                <a href="logout" class="px-1 text-red-500">Logout</a>
                            </li>
                        </ul>

                    </span>
                </div>
            @else
                <div class="flex justify-center items-center gap-11">
                    <a href="register" class="hover:underline">register</a>
                    <a href="login" class="hover:underline bg-[#001D86] text-white rounded-full px-6 py-1">login</a>
                </div>
            @endif
        </header>
    </div>

    <div class="text-center h-full relative overflow-hidden">
        <div class="my-16 md:mx-auto max-w-[1080px]">
            @yield('jumbotron')
        </div>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -top-20 -right-16"></span>
        <span class="bg-[#f0f1f3] w-44 h-44 ornament top-20"></span>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -bottom-34 right-28"></span>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -bottom-10 -left-24"></span>
        <span class="bg-[#f0f1f3] w-28 h-28 ornament left-28 -top-20"></span>
    </div>

    <main class=" bg-white">
        <div class="max-w-[1000px] py-16 mx-auto flex justify-start gap-5">
            @yield('content')
            <div class="h-max w-2/5 p-3 border-2 border-slate-100 rounded-md sticky top-5">
                @yield('sidebar')
            </div>
        </div>
    </main>
</body>

</html>
