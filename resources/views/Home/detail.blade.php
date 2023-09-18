@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover:underline">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/">Kembali</a>
    </div>
@endsection
@section('content')
    <div class="min">
        <h1 class="text-black text-3xl font-bold mb-5">{{ $lowongan->name }}</h1>
        <p>{!! $lowongan->desc !!}</p>
        <h3 class="my-2 font-bold text-xl">Keuntungan</h3>
        <p>{!! $lowongan->benefit !!}</p>
        <h3 class="my-2 font-bold text-xl">Kualifikasi</h3>
        <p>{!! $lowongan->kualifikasi !!}</p>
    </div>
@endsection
@section('sidebar')
    <div class="sidebar">
        <button x-on:click='apply = !apply'
            class="bg-[#000D3B] py-2 px-5 hover:underline rounded hover:opacity-80 w-full text-slate-50">Apply
            Lowongan</button>
        <a href="#" class="my-3 cursor-pointer hover:underline text-center block">Hubungi Kita</a>
        <div class="mt-8">
            <p class="text-slate-700">Dipublis pada</p>
            <h3 class="font-bold text-md">{{ $lowongan->created_at }}</h3>
        </div>
    </div>
@endsection
