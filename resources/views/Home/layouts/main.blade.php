<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Monda:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-slate-100 m-0 relative" x-cloak :class="apply ? 'overflow-hidden' : 'overflow-x-hidden'"
    x-data='apply'>
    @if (Auth::user()->is_active == 0)
        <p class="bg-yellow-300 text-center py-5 w-full">Akun anda belum terverifikasi,
            silahkan
            verifikasi dengan mengklik
            tautan <a href="/email/verifikasi" class="underline">berikut</a>
        </p>
    @endif
    @if (session('success'))
        <p class="text-green-500">{{ session('success') }}</p>
    @endif
    <div class="bg-white">
        <header class="flex py-5 shadow-sm mx-5 md:mx-auto max-w-[1080px] justify-between items-center">
            <img src="{{ asset('images/jetorbit-logo.png') }}" class="mix-blend-multiply w-28" alt="">

            @if (Auth::check())
                <div x-data="{ open: false }" class="relative z-20">
                    <div class="flex items-center">
                        <p x-on:click="open = ! open" class="cursor-pointer">Hello, <strong>{{ Auth::user()->name }}
                            </strong></p>
                        <img src="{{ asset('assets/chevron.svg') }}" width="20" class='opacity-50'
                            x-bind:class="open ? 'rotate-180' : ''" alt="arrow down">
                    </div>

                    <span x-show="open" x
                        class="bg-white shadow-md  border-[1px] border-slate-100 absolute w-full mt-4 rounded-md">
                        <ul class="py-3 px-2 text-center">
                            <li class="p-1 mb-3 rounded flex cursor-pointer items-center hover:bg-slate-200 px-1">
                                <a href="{{ url('update-profile') }}" class="px-1" class="flex">
                                    <div class="flex">
                                        <img src="{{ asset('assets/person.svg') }}" width="24" alt="person">
                                        <span class="d-inline">Profile</span>
                                    </div>
                                </a>
                            </li>
                            <li class="flex p-1 rounded hover:bg-slate-200 items-center cursor-pointer"> <img
                                    src="{{ asset('assets/logout.svg') }}" alt="log out">
                                <a href="/logout" class="px-1 text-red-500">Logout</a>
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
        <div class="my-10 mx-5 md:mx-auto max-w-[1080px]">
            @yield('jumbotron')
        </div>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -top-20 -right-16"></span>
        <span class="bg-[#f0f1f3] w-44 h-44 ornament top-20"></span>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -bottom-34 right-28"></span>
        <span class="bg-[#EAEEFF] w-60 h-60 ornament -bottom-10 -left-24"></span>
        <span class="bg-[#f0f1f3] w-28 h-28 ornament left-28 -top-20"></span>
    </div>

    <main class="bg-white">
        <div class="max-w-[1000px] py-16 mx-auto flex-col-reverse flex md:flex-row justify-start gap-5 px-5">
            @yield('content')
            <div class="h-max w-full md:w-2/5 p-3 border-2 border-slate-100 rounded-md md:sticky top-5">
                @yield('sidebar')
            </div>
        </div>
    </main>

    {{-- <div class="fixed flex w-full top-0 bottom-0 justify-center items-center bg-gray-700/40 overflow-auto z-20 p-5 shadow-md"
        x-show='apply' x-transition>
        <div class="bg-white rounded-md w-[34rem] h-max p-5 my-5 gap-5 flex items-start">
            <div class="w-28 rounded-lg h-full bg-blue-900">
                <p class="indicator" :class="current_pos == 1 ? 'active' : 'text-white'">
                    1</p>
                <p class="indicator" :class="current_pos == 2 ? 'active' : 'text-white'">
                    2</p>
                <p class="indicator" :class="current_pos == 3 ? 'active' : 'text-white'">
                    3</p>
            </div>
            <div class="w-50">
                <header class="flex mb-5 justify-between items-center">
                    <h1 class="text-center text-xl">Silahkan Dilengkapi:</h1>
                    <img x-on:click='apply = !apply' class="cursor-pointer" src="{{ asset('assets/close.svg') }}"
                        alt="">
                </header>
                <form action="{{ url('apply-form') }}" id="container" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="first" x-show="current_pos == 1" x-transition>

                        <label for="tgl-mulai">Tanggal Mulai</label>
                        <input type="date" name="tgl-mulai" id="tgl-mulai"
                            class="py-2 mb-3 px-3 w-full mr-3 bg-slate-200 rounded-sm" id="tipe-magang">

                        <label for="tgl-selesai">Tanggal Selesai</label>
                        <input type="date" name="tgl-selesai" id="tgl-selesai"
                            class="py-2 mb-3 px-3 w-full mr-3 bg-slate-200 rounded-sm" id="tipe-magang">
                        <button
                            class="py-2 bg-gray-300 px-5 hover:underline rounded hover:opacity-80 mt-5 my-3 flex justify-end ml-auto text-slate-950"
                            x-on:click.prevent="next()">Berikutnya</button>

                    </div>

                    <div class="second" x-show="current_pos == 2" x-transition>
                        @if ($errors->has('sudah-Apply'))
                            <div class="alert alert-danger">
                                {{ $errors->first('sudah-Apply') }}
                            </div>
                        @endif

                        @if ($errors->has('sudah-lulus'))
                            <div class="alert alert-danger">
                                {{ $errors->first('sudah-lulus') }}
                            </div>
                        @endif
                        <button
                            class="bg-[#000D3B] py-2 px-5 hover:underline rounded hover:opacity-80 mt-5 my-3 ml-auto text-slate-50 w-full"
                            x-on:click.prevent='add_new'>Tambah
                            Anggota</button>

                        <div x-html='html'></div>

                        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
               
                        <div class="flex justify-between items-center hover:underline">
                            <button x-on:click.prevent="previous()"
                                class="py-2 bg-gray-300 px-5 hover:underline block rounded hover:opacity-80 mt-5 my-3 text-slate-950">Sebelumnya</button>
                            <button
                                class="py-2 bg-gray-300 px-5 hover:underline rounded hover:opacity-80 mt-5 my-3 ml-auto text-slate-950"
                                x-on:click.prevent="next()">Berikutnya</button>
                        </div>
                    </div>
                    <div class="w-full" x-show="current_pos==3" x-transition>

                        <label for="alamat">Alamat</label> <br>
                        <input type="text" name="alamat" id="alamat"
                            class="py-2 px-3 w-full mb-3 bg-slate-200 rounded-sm">

                        <label for="cv">CV</label>
                        <input type="file" name="cv"
                            class="py-2 mb-3 px-3 w-full mr-3 bg-slate-200 rounded-sm" id="cv" />

                        @error('cv')
                            {{ $message }}
                        @enderror

                        <div class="flex justify-between items-center hover:underline">
                            <button x-on:click.prevent="previous()"
                                class="py-2 bg-gray-300 px-5 hover:underline rounded hover:opacity-80 mt-5 my-3 text-slate-950">Sebelumnya</button>
                            <button type="submit"
                                class="bg-[#000D3B] py-2 px-5 hover:underline rounded hover:opacity-80 mt-5 my-3 ml-auto text-slate-50">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</body>

</html>
