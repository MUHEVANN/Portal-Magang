@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover-underline w-fit">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/" class="block">Kembali</a>
    </div>
@endsection
@section('content')
    <div class="container-width flex-col">
        <h1 class="text-slate-750 text-2xl">Halo, <span class="font-bold">{{ Auth::user()->name }}</span></h1>
    </div>
@endsection
