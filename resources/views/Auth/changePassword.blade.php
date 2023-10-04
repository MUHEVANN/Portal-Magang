<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
</body>

</html>

@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover-underline">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/">Kembali</a>
    </div>
@endsection
@section('content')
    <div class="mx-auto sm:w-7/12 p-5 rounded-md border-[1px] bg-white shadow-sm border-slate-100" x-data="apply">
        <h1 class="sub-title">Ganti Password</h1>
        <form action="{{ url('changePassword') }}" method="post">
            @csrf
            <label for="verif_code">Kode</label> <br>
            <div class="flex items-center">
                <input type="verif_code" id="verif_code" name="verif_code" class="w-3/5 input-style">
                <a x-on:click="send_code()" class="btn-style w-2/5">Kirim Kode</a>
            </div>

            <label for="password">Password</label> <br>
            <input type="password" id="password" name="password" class="input-style">

            <button type="submit" class="btn-style">Change Password</button>
        </form>
    </div>
@endsection
