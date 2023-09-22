<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">
    <div class="container bg-white p-5 m-10 overflow-hidden shadow-md w-[720px] rounded-md">

        <img src="{{ asset('storage/lowongan/230903010539.jpg') }}" class="h-48 object-cover flex justify-center w-full"
            alt="jetorbit logo">
        <div class="my-10">
            <h3>
                {{-- Halo <strong>{{ Auth::user()->name }}</strong>. --}}
            </h3>
            <p class="my-5">
                Berikut merupakan Link verifikasi untuk bisa mengaktifkan akun anda.
                <a href="{{ route('verif', ['verif' => $user]) }}" class="text-blue-700 hover:underline">Verifikasi
                    Akun</a>
            </p>
            <p class="my-5">Terimakasih, <br> <span class="text-slate-500">Tim Jetorbit</span></p>
        </div>
    </div>
</body>

</html>
