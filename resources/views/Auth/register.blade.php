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
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-100 flex flex-wrap h-screen content-center justify-center">
    <div class="bg-white h-fit flex align-middle shadow-sm rounded-md">
        <img src="images/Login.png" class="bg-center w-96 h-auto rounded-lg object-fill p-5" alt="login jetorbit logo">
        <section class="p-10 sm:w-[30rem]">
            <span class="block text-right text-sm opacity-50 text-gray-700">Sudah punya akun? <a
                    class="hover:underline text-[#001D86]" href="login">Login</a></span>
            <h1 class="my-5 text-3xl">Registrasi</h1>
            <form action="{{ url('register') }}" method="post">
                @csrf
                @if ($errors->any())
                    <div class="text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <label for="nama" class=" text-slate-900 mb-1">Nama</label> <br>
                <div class="relative">
                    <input type="nama" name="name" class="pl-11 bg-slate-200 py-2 mb-2 px-2 w-full"> <br>
                    <img src="assets/person.svg" class="absolute w-6 top-2 left-3" alt="">
                </div>
                @if ($errors->any() && $errors->nama)
                    <p class="text-red-600">{{ $errors->first('nama') }}</p>
                @endif
                <br>
                <label for="email" class=" text-slate-900 mb-1">Email</label> <br>
                <div class="relative">
                    <input type="email" name="email" class="pl-11 bg-slate-200 py-2 mb-2 px-2 w-full"> <br>
                    <img src="assets/email.svg" class="absolute w-6 top-2 left-3" alt="">
                </div>
                @if ($errors->any() && $errors->email)
                    <p class="text-red-600">{{ $errors->first('email') }}</p>
                @endif
                <br>
                <label for="password" class="text-slate-900">Password</label>
                <div class="relative">
                    <input type="password" id='pass' name="password" class="pl-11 bg-slate-200 py-2 px-2 w-full">
                    <img src="assets/pass.svg" class="absolute w-6 top-2 left-3" alt="">
                    <img src="assets/close-eye.svg" id='indicator' onclick="changeVisiblity()"
                        class="absolute cursor-pointer w-6 top-2 right-3" alt="">
                </div>
                @if ($errors->any() && $errors->password)
                    <p class="text-red-600">{{ $errors->first('password') }}</p>
                @endif
                <br>
                <button type="submit"
                    class=" text-pink-100 cursor-pointer bg-[#001D86] mt-9 my-6 py-2 px-4 w-full">Registrasi</button>
                <a class="text-center cursor-pointer block hover:underline" href="login">Login</a>
            </form>
        </section>
    </div>
</body>
<script src='{{ asset('js/main.js') }}'></script>

</html>
