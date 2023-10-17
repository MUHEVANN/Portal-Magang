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

            <img src="{{ '/storage/lowongan/' . $lowongan->gambar }}" class="rounded-md w-full my-5" alt="gambar">

            <h3 class="my-2 font-bold text-xl">Diskripsi</h3>
            <p>{!! $lowongan->desc !!}</p>
            <h3 class="my-2 font-bold text-xl">Keuntungan</h3>
            <p>{!! $lowongan->benefit !!}</p>
            <h3 class="my-2 font-bold text-xl">Kualifikasi</h3>
            <p>{!! $lowongan->kualifikasi !!}</p>
        </div>
        <div class="sidebar">
            @if (!Auth::check())
                <button disabled
                    class="bg-[#000D3B] opacity-60 cursor-not-allowed w-full py-2 px-5 block text-center rounded hover:opacity-50 text-slate-50">Lamar
                    Magang</button>
            @else
                @if (Auth::user()->is_active == 0)
                    <button disabled
                        class="bg-[#000D3B] opacity-60 cursor-not-allowed w-full py-2 px-5 block text-center rounded hover:opacity-50 text-slate-50">Lamar
                        Magang</button>
                @else
                    <a href='{{ url('apply-form') }}'
                        class="bg-[#000D3B] py-2 px-5 block text-center rounded hover:opacity-80 text-slate-50">Lamar
                        Magang</a>
                @endif
            @endif
            <a href="#" class="my-3 cursor-pointer hover-underline text-center block">Hubungi Kita</a>
            <div class="mt-8">
                <p class="text-slate-500 mb-1">Diperbaru pada</p>
                <h3 class="font-medium text-md">{{ date('d F Y', strtotime($lowongan->updated_at)) }}</h3>
            </div>
            <div class="mt-5">
                <p class="text-slate-500 mb-1">Berakhir Pada</p>
                <h3 class="font-medium text-md">{{ date('d F Y', strtotime($lowongan->deadline)) }}</h3>
            </div>
        </div>
    </div>
@endsection
