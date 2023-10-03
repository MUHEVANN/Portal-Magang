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
        <div class="min">
            <h1 class="text-black text-3xl font-bold mb-5">{{ $lowongan->name }}</h1>
            <img src="{{ $lowongan->gambar }}" class="rounded-md w-5/5 h-3/5 my-5" alt="gambar">
            <h3 class="my-2 font-bold text-xl">Diskripsi</h3>
            <p>{!! $lowongan->desc !!}</p>
            <h3 class="my-2 font-bold text-xl">Keuntungan</h3>
            <p>{!! $lowongan->benefit !!}</p>
            <h3 class="my-2 font-bold text-xl">Kualifikasi</h3>
            <p>{!! $lowongan->kualifikasi !!}</p>
        </div>
        <div class="sidebar">
            <a href="#" class="my-3 cursor-pointer hover-underline text-center block">Hubungi Kita</a>
            <div class="mt-8">
                <p class="text-slate-700">Dipublis pada</p>
                <h3 class="font-bold text-md">{{ date('d F Y', strtotime($lowongan->created_at)) }}</h3>
            </div>
        </div>
    </div>
@endsection
