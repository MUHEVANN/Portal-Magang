{{-- @extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable')) --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>503 SERVICE UNAVAILABLE</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 h-screen flex justify-center items-center">
    <div>
        <h1 class="text-slate-900 text-5xl font-extrabold">503 SERVICE UNAVAILABLE</h1>
        <p class="text-slate-500 my-1">Server tidak tersedia!</p>

        <a href="/"
            class="inline-block hover:bg-slate-800 bg-slate-600 py-2 mt-6 px-6 rounded-sm text-slate-50">Kembali ke
            Beranda</a>
    </div>
</body>

</html>
