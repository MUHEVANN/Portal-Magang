<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Jetorbit Intern</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="antialiased bg-slate-100 m-0 relative h-full" x-cloak
    :class="isOpen ? 'overflow-hidden' : 'overflow-x-hidden'" x-data='apply'>
    <span class="absolute bg-slate-900 sml:hidden z-[11] opacity-50 top-0 h-full w-full"
        :class="isOpen ? 'block' : 'hidden'" x-on:click="isOpen = !isOpen"></span>
    @if (Auth::check() && Auth::user()->is_active == 0)
        <p class="bg-yellow-300 text-center py-5 w-full">Akun anda belum terverifikasi,
            silahkan
            verifikasi dengan mengklik
            tautan <button type="button" class="hover-underline verif">berikut</button>
        </p>
    @endif
    @if (session('success'))
        <p x-init='$nextTick(() => {
            verified("<?= session('success') ?>")
            })'></p>
    @endif

    @if (session('error'))
        <p x-init='$nextTick(() => {
            verified("<?= session('error') ?>","error")
            })'></p>
    @endif

    @if ($errors->all())
        @foreach ($errors->all() as $error)
            <p x-init='$nextTick(() => {
            verified("<?= $error ?>","error")
                })'></p>
        @endforeach
    @endif

    <div class="bg-white sticky shadow-sm top-0 z-10">
        <header class="flex py-5 mx-5 1xl:mx-auto max-w-[1440px] justify-between items-center">
            <img src="{{ asset('images/jetorbit-logo.png') }}" class="mix-blend-multiply w-28" alt="">

            @if (Auth::check())
                <div x-data="{ open: false }" class="hidden sml:block relative z-20" x-on:click.outside='open = false'>
                    <div x-on:click="open = ! open" class="flex cursor-pointer transition items-center gap-2">
                        <strong>{{ Auth::user()->name }}</strong>
                        <img class="rounded-full object-cover w-8 h-8"
                            src=" {{ Auth::user()->profile_image === null ? asset('images/profile.jpg') : asset('storage/profile/' . Auth::user()->profile_image) }}"
                            alt="user profile">
                        <img src="{{ asset('assets/chevron.svg') }}" alt="" class="transition"
                            :class="open ? 'rotate-180' : ''">
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
                <img src="{{ asset('assets/menu.svg') }}" alt="" class="sml:hidden"
                    x-on:click="isOpen = !isOpen">
            @else
                <div class="flex justify-center items-center gap-4">
                    <a href="/register" class="hover:underline">register</a>
                    <a href="/login" class="hover:underline bg-[#001D86] text-white rounded-full px-5 py-1">login</a>
                </div>
            @endif

        </header>
    </div>

    @if (Auth::check())
        <div class="fixed top-0 right-0 w-8/12 h-screen z-[12] sml:hidden bg-slate-50" x-show="isOpen"
            x-transition:enter="translate-x-10 ease-in"x-transition:leave="translate-x-10 ease-out">
            <img src="{{ asset('assets/close.svg') }}" alt="" x-click.away="isOpen = false"
                class="my-5 ml-auto mr-5" x-on:click="isOpen = !isOpen">
            <ul>
                <li
                    class="list-none text-center flex flex-col items-center gap-3 border-[1px] bg-slate-50 border-slate-200 m-2 p-2 rounded">
                    <img class="rounded-full object-cover w-11 h-11"
                        src=" {{ Auth::user()->profile_image === null ? asset('images/profile.jpg') : asset('storage/profile/' . Auth::user()->profile_image) }}"
                        alt="user profile">
                    <strong>{{ Auth::user()->name }}</strong>

                </li>
                <li class="list-none text-center mt-7 hover-underline"><a href="/update-profile"> Edit Profile</a></li>
                <li class="list-none text-center mt-7 hover-underline text-red-500"><a href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    @endif

    <div class="text-center h-full relative overflow-hidden" id="top">
        <div class="my-10 mx-5 1xl:mx-auto max-w-[1440px]">
            @yield('jumbotron')
        </div>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -top-20 -right-16"></span>
        <span class="bg-[#f0f1f3] w-44 h-44 ornament top-20"></span>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -bottom-34 right-28"></span>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -bottom-10 -left-24"></span>
        <span class="bg-[#f0f1f3] w-28 h-28 ornament left-28 -top-20"></span>
    </div>

    <main class="bg-[#fcfcfc] pb-5">
        <div class="py-16">
            @yield('content')
        </div>
        {{-- <div class="py-16 container-width">
            @yield('content')
            @yield('sidebar')
        </div> --}}
        <a href="#top" x-on:scroll.window="scrollPos()" :class="top_position ? 'hidden' : ''"
            class="bg-[#e7e7e7] p-4 block w-14 h-14 sticky bottom-5 right-5 opacity-50 ml-auto backdrop-blur-3xl">
            <img src="{{ asset('assets/chevron.svg') }}" class="rotate-180 w-full" alt="">
        </a>
    </main>
    <footer class="bg-[#000D3B]">
        <div class="flex flex-col px-5 sm:flex-row max-w-[1200px] mx-auto items-center text-white justify-between">
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
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/locale/id.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('script')
    <script>
        $(document).ready(function() {
            $('.verif').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/email/verifikasi') }}",

                    success: function(response) {
                        const Toast = Swal.mixin({
                            width: 400,
                            padding: 18,
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter',
                                    Swal.stopTimer)
                                toast.addEventListener('mouseleave',
                                    Swal.resumeTimer)
                            }
                        })

                        Toast.fire({

                            icon: 'success',
                            title: response.success
                        })
                    }
                });
            });
        });
    </script>
</body>

</html>
