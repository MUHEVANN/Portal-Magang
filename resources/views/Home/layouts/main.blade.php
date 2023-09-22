<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monda:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-slate-100 m-0 relative" x-cloak :class="apply ? 'overflow-hidden' : 'overflow-x-hidden'"
    x-data='apply'>
    @if (Auth::check() && Auth::user()->is_active == 0)
        <p class="bg-yellow-300 text-center py-5 w-full">Akun anda belum terverifikasi,
            silahkan
            verifikasi dengan mengklik
            tautan <button type="button" class="underline verif">berikut</button>
        </p>
    @endif
    @if (session('success'))
        <p class="text-green-500">{{ session('success') }}</p>
    @endif
    <div class="bg-white">
        <header class="flex py-5 shadow-sm mx-5 lg:mx-auto max-w-[1080px] justify-between items-center">
            <img src="{{ asset('images/jetorbit-logo.png') }}" class="mix-blend-multiply w-28" alt="">

            @if (Auth::check())
                <div x-data="{ open: false }" class="relative z-20" x-on:click.outside='open = false'>
                    <div x-on:click="open = ! open" class="flex cursor-pointer items-center gap-2">
                        <strong>{{ Auth::user()->name }}</strong>
                        {{-- {{ dd(Auth::user()->profile_image) }} --}}
                        <img class="rounded-full object-cover w-8 h-8"
                            src=" {{ Auth::user()->profile_image === null ? asset('images/profile.jpg') : asset('storage/profile/' . Auth::user()->profile_image) }}"
                            alt="user profile">
                        <img src="{{ asset('assets/chevron.svg') }}" alt="" :class="open ? 'rotate-180' : ''">
                    </div>

                    <span x-show="open"
                        class="bg-white shadow-md border-[1px] border-slate-100 w-max right-0 absolute mt-4 rounded-md">
                        <div class="py-3 px-2 text-center">
                            <a href="/update-profile"
                                class="p-1 mb-3 rounded flex cursor-pointer items-center hover:bg-slate-200 px-1"> <img
                                    src="{{ asset('assets/person.svg') }}" width="24" alt="person">
                                <p class="px-1">Profile</p>
                            </a>
                            <a href="/logout" class="flex p-1 rounded hover:bg-slate-200 items-center cursor-pointer">
                                <img src="{{ asset('assets/logout.svg') }}" alt="log out">
                                <p class="px-1 text-red-500">Logout</p>
                            </a>
                        </div>
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
        <div class="my-10 mx-5 lg:mx-auto max-w-[1080px]">
            @yield('jumbotron')
        </div>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -top-20 -right-16"></span>
        <span class="bg-[#f0f1f3] w-44 h-44 ornament top-20"></span>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -bottom-34 right-28"></span>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -bottom-10 -left-24"></span>
        <span class="bg-[#f0f1f3] w-28 h-28 ornament left-28 -top-20"></span>
    </div>

    <main class="bg-white">
        <div class="py-16 container-width">
            @yield('content')
            @yield('sidebar')
        </div>
    </main>
    <footer class="bg-[#000D3B]">
        <div class="flex flex-col px-5 sm:flex-row max-w-[1000px] mx-auto items-center text-white justify-between">
            <img src="{{ asset('images/jetorbit-logo-white.png') }}" class="w-40 sm:h-40 mt-7 sm:mt-0 object-contain"
                alt="">

            <ul class="list-contents sm:my-0 my-10">
                <li><a href="#" class="list-menu">Kontak</a></li>
                <li><a href="#" class="list-menu">Layanan</a></li>
                <li><a href="#" class="list-menu">Bantuan</a></li>
            </ul>
            <ul class="list-contents sm:mb-0 mb-7">
                <li><a href="#"><img class="svg-social" src="{{ asset('assets/socials/facebook.svg') }}"
                            alt="facebook"></a></li>
                <li><a href="#"><img class="svg-social" src="{{ asset('assets/socials/twitter.svg') }}"
                            alt="twitter"></a></a>
                </li>
                <li><a href="#"><img class="svg-social" src="{{ asset('assets/socials/instagram.svg') }}"
                            alt="instagram"></a></a></li>
            </ul>
        </div>
    </footer>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('script')

</body>

</html>
