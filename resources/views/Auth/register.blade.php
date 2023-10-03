<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monda:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 flex flex-wrap h-screen content-center justify-center" x-data="gates" x-cloak>
    <div class="bg-white h-fit flex align-middle shadow-sm rounded-md">
        <img src="images/Login.png" class="bg-center w-96 h-auto rounded-lg object-cover p-5" alt="login jetorbit logo">
        <section class="py-8 px-7 sm:w-[30rem]">
            <span class="block text-right text-sm opacity-50 text-gray-700">Sudah punya akun? <a
                    class="hover:underline text-[#001D86]" href="login">Login</a></span>
            <h1 class="my-5 text-2xl">Registrasi</h1>
            <form action="{{ url('register') }}" method="post" @submit="match()">
                @csrf
                <label for="nama" class=" text-slate-900 mb-1">Nama</label> <br>
                <div class="relative mt-2">
                    <input type="nama" name="name" value="{{ old('name') }}"
                        class="pl-11 bg-gray-100 py-2 mb-1 px-2 w-full" required> <br>
                    <img src="assets/person.svg" class="absolute w-6 top-2 left-3" alt="">
                </div>
                @if ($errors->any() && $errors->nama)
                    <p class="text-red-600">{{ $errors->first('nama') }}</p>
                @endif
                <br>
                <label for="email" class=" text-slate-900">Email</label> <br>
                <div class="relative mt-2">
                    <input type="email" name="email" class="pl-11 bg-gray-100 py-2 mb-2 px-2 w-full" required> <br>
                    <img src="assets/email.svg" class="absolute w-6 top-2 left-3" alt="">
                </div>
                @if ($errors->any() && $errors->email)
                    <p class="text-red-600">{{ $errors->first('email') }}</p>
                @endif
                <br>
                <label for="password" class="text-slate-900">Password</label>

                <div class="relative mt-2" x-transition>
                    <input :type="!isVisible1 ? 'password' : 'text'" id='pass1' x-model="FirstPASS" name="password"
                        class="pl-11 bg-gray-100 py-2 px-2 w-full" required>
                    <img src="assets/pass.svg" class="absolute w-6 top-2 left-3" alt="">
                    <img :src="!isVisible1 ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator'
                        x-on:click='toggle1()' class="absolute cursor-pointer w-6 top-2 right-3" alt="">
                </div>
                @if ($errors->any() && $errors->password)
                    <p class="text-red-600">{{ $errors->first('password') }}</p>
                @endif
                <br>
                <label for="password" class="text-slate-900">Ulangi Password</label>

                <div class="relative mt-2" x-transition>
                    <input :type="!isVisible2 ? 'password' : 'text'" x-model="SecondPASS" id='pass2'
                        name="ulangi-password" class="pl-11 bg-gray-100 py-2 px-2 w-full" required>
                    <img src="assets/pass.svg" class="absolute w-6 top-2 left-3" alt="">
                    <img :src="!isVisible2 ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator'
                        x-on:click='toggle2()' class="absolute cursor-pointer w-6 top-2 right-3" alt="">
                </div>
                @if ($errors->any() && $errors->password)
                    <p class="text-red-600">{{ $errors->first('password') }}</p>
                @endif
                <br>

                <div x-show="warningMsg" class="flex items-center pb-2 pt-2">
                    <div class="bg-red-200 text-red-700 rounded-full p-1 fill-current ">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <span class="text-red-700 font-medium text-sm ml-3" x-text="warningMsg"></span>
                </div>

                <button
                    class=" text-pink-100 cursor-pointer bg-[#001D86] mt-3 mb-4 py-2 px-4 w-full">Registrasi</button>
                <a class="text-center cursor-pointer block hover:underline" href="login">Login</a>
            </form>
        </section>
    </div>
</body>
<script src="{{ asset('js/main.js') }}"></script>

</html>
