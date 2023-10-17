<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monda:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 flex flex-wrap h-screen content-center justify-center border-[2px] border-slate-400">
    <div x-data="apply"
        class="bg-white h-full md:h-[30rem] justify-center w-[45rem] flex items-center flex-col md:flex-row shadow-sm border-2 border-gray-100 rounded-md">
        @if (session('success'))
            <p class="text-green-500" x-init='$nextTick(() => {
                verified("<?= session('success') ?>")
                })'></p>
        @endif
        {{-- {{ session()->all() }} --}}
        <section class="p-10 w-full sml:w-4/6 sm:w-[25rem]">
            <div class="my-5">
                <h1 class="my-2 text-2xl">Login</h1>
                <span class="block text-sm opacity-50 text-gray-700">Belum punya akun? <a
                        class="hover-underline text-[#001D86]" href="register">Registrasi</a></span>
            </div>
            <form action="{{ url('login') }}" method="post">
                @csrf
                <div class="relative">
                    <input type="email" name="email" class="auth-input mb-2" placeholder="e.g. fulan@email.com"
                        value='{{ old('email') }}'>
                    <br>
                    <img src="assets/email.svg" class="absolute w-6 top-2 left-1" alt="">
                </div>
                @if ($errors->any() && $errors->email)
                    <p class="text-red-600">{{ $errors->first('email') }}</p>
                @endif
                <br>
                <div class="relative" x-data="{
                    isVisible: false,
                    toggle() {
                        this.isVisible = !this.isVisible;
                    }
                }" x-transition>
                    <input :type="!isVisible ? 'password' : 'text'" id='pass' value="{{ old('password') }}"
                        name="password" class="auth-input" placeholder="password">
                    <img src="assets/pass.svg" class="absolute w-6 top-2 left-1" alt="">
                    <img :src="!isVisible ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator'
                        x-on:click='toggle()' class="absolute cursor-pointer w-6 top-2 right-3" alt="">
                </div>
                @if ($errors->any() && $errors->password)
                    <p class="text-red-600">{{ $errors->first('password') }}</p>
                @endif
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-x-1">
                        <input type="checkbox" name='remember' id='remember' class="">
                        <label for="remember" class="text-xs">Remember me</label>
                    </div>
                    <a href="verif-email-changePassword" class="text-blue-800 text-xs py-5 hover-underline">Lupa
                        password</a>
                </div>
                <br>
                <button type="submit"
                    class=" text-pink-100 cursor-pointer rounded bg-[#001D86] mb-6 p-2 px-4 w-full">Login</button>
                <a class="text-center cursor-pointer block hover-underline" href="register">Register</a>
            </form>
        </section>
        {{-- <img src="images/login2.svg" class="bg-center w-96 h-auto rounded-lg hidden md:block object-fill p-5"
        alt="login jetorbit logo"> --}}
        <img src="images/Login.png" class="bg-center w-[21rem] h-full hidden md:block rounded-lg object-fill p-1"
            alt="login jetorbit logo">

    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
