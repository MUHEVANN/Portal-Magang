<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-100 w-full h-screen flex justify-center align-middle">
    <form action="{{ url('login') }}" method="post" class="bg-white self-center p-20  sm:w-[40rem]">
        @csrf
        {{-- @if ($errors->any())
            <div class="text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <label for="email" class=" text-slate-900 mb-1">Email</label> <br>
        <input type="email" name="email" class="bg-slate-200 py-1 mb-2 px-2 w-full"> <br>
        @if ($errors->any() && $errors->email)
            <p class="text-red-600 mb-4">{{ $errors->first('email') }}</p>
        @endif
        <label for="password" class=" text-slate-900">Password</label> <br>
        <input type="password" name="password" class="bg-slate-200 py-1 px-2 w-full">
        @if ($errors->any() && $errors->password)
            <p class="text-red-600">{{ $errors->first('password') }}</p>
        @endif
        <br>
        <button type="submit" class=" text-pink-100 cursor-pointer bg-black my-6 py-2 px-4 w-full">Login</button>
        <p class="text-center cursor-pointer">Register</p>
    </form>
</body>

</html>
