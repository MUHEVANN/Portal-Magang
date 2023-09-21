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
    @vite(['resources/css/app.css', 'resources/js/main.js'])
</head>

<body class="bg-slate-100 flex flex-wrap h-screen content-center justify-center ">
    <div class="bg-white h-[60vh] w-[45vw] flex items-center shadow-sm rounded-md ">
        {{-- <img src="images/Login.png" class="bg-center w-96 h-auto rounded-lg object-fill p-5" alt="login jetorbit logo"> --}}

        <section class="p-10  sm:w-[25rem]">
            <div class="my-5">
                <h1 class="my-2 text-2xl">Login</h1>
                <span class="block text-sm  text-gray-700">Belum punya akun? <a class="underline text-[#3c54ac]"
                        href="register">buat
                        akun</a></span>
            </div>
            <form action="{{ url('login') }}" method="post">
                @csrf
                {{-- <label for="email" class=" text-slate-900 mb-1">Email</label> <br> --}}
                <div class="relative">
                    <input type="email" name="email" class="pl-11 border-b-2 py-2 mb-2 px-2 w-full"
                        placeholder="email"> <br>
                    <img src="assets/email.svg" class="absolute w-6 top-2 left-3" alt="">
                </div>
                @if ($errors->any() && $errors->email)
                    <p class="text-red-600">{{ $errors->first('email') }}</p>
                @endif
                <br>
                {{-- <label for="password" class="text-slate-900">Password</label> --}}
                <div class="relative" x-data="{
                    isVisible: false,
                    toggle() {
                        this.isVisible = !this.isVisible;
                    }
                }" x-transition>
                    <input :type="!isVisible ? 'password' : 'text'" id='pass' name="password"
                        class="pl-11 border-b-2 py-2 px-2 w-full" placeholder="password">
                    <img src="assets/pass.svg" class="absolute w-6 top-2 left-3" alt="">
                    <img :src="!isVisible ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator'
                        x-on:click='toggle()' class="absolute cursor-pointer w-6 top-2 right-3" alt="">
                </div>
                @if ($errors->any() && $errors->password)
                    <p class="text-red-600">{{ $errors->first('password') }}</p>
                @endif
                <span class="block text-sm  text-gray-700">Dengan ini kamu setuju</span>
                <br>
                <div class="flex justify-center">

                    <button type="submit"
                        class=" text-pink-100 cursor-pointer bg-[#001D86] mt-9 my-6 py-2 px-10 rounded-full">Login</button>
                </div>
                {{-- <button type="submit"
                    class=" text-pink-100 cursor-pointer bg-[#001D86] mt-9 my-6 py-2 px-4 w-full">Login</button> --}}
                {{-- <a class="text-center cursor-pointer block hover:underline" href="register">Register</a> --}}
            </form>
        </section>
        <img src="images/login2.svg" class="bg-center w-96 h-auto rounded-lg  object-fill p-5"
            alt="login jetorbit logo">

    </div>
</body>

</html>
