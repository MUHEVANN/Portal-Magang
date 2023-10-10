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
    <div class="mx-auto sm:w-7/12 p-5 rounded-md border-[1px] bg-white shadow-sm border-slate-100" x-data="gates">
        <h1 class="sub-title">Ganti Password</h1>
        <form action="{{ url('ganti-password') }}" method="post" x-on:submit="changePassword">
            @csrf
            <label for="password_lama">Password Lama</label><br>

            <div class="relative mt-2" x-transition>
                <input :type="!isVisible ? 'password' : 'text'" x-model="old_pass" id='password_lama' name="password_lama"
                    class=" bg-gray-100 py-2 px-2 w-full" required>
                <img :src="!isVisible ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator' x-on:click='toggle()'
                    class="absolute cursor-pointer w-6 top-2 right-3" alt="">
            </div>

            <span class="text-red-500 mb-2" x-text="old_pass_invalid"></span>

            <hr class="my-5">
            <h3 class="text-xl text-center mb-3 opacity-80">Ketikan Password Baru</h3>

            <label for="password_baru">Password</label> <br>
            <div class="relative mt-2" x-transition>
                <input :type="!isVisible1 ? 'password' : 'text'" x-model="new_pass" id='password_baru' name="password_baru"
                    class=" bg-gray-100 py-2 px-2 w-full" required>
                <img :src="!isVisible1 ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator' x-on:click='toggle1()'
                    class="absolute cursor-pointer w-6 top-2 right-3" alt="">
            </div>


            <span class="text-red-500 mb-2" x-text="new_pass_invalid"></span> <br>


            <label for="confirm_password">Ulangi Password</label> <br>
            <div class="relative mt-2" x-transition>
                <input :type="!isVisible2 ? 'password' : 'text'" x-model="repeat_pass" id='confirm_password'
                    name="confirm_password" class=" bg-gray-100 py-2 px-2 w-full" required>
                <img :src="!isVisible2 ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator' x-on:click='toggle2()'
                    class="absolute cursor-pointer w-6 top-2 right-3" alt="">
            </div>
            <span class="text-red-500" x-text="repeat_pass_invalid"></span> <br>

            <button type="submit" class="btn-style">Ubah Password</button>
        </form>
    </div>
@endsection
