@extends('Home.layouts.main')

@section('jumbotron')
    <h1 class="text-xl md:text-4xl sm:text-2xl pt-10 font-bold m-auto font-title w-10/12 sm:w-9/12 md:w-7/12">DAPATKAN
        KESEMPATAN
        MAGANG BERSAMA
        <span class="text-[#001D86] font-title">JETORBIT</span>
    </h1>
    <div class="flex gap-6 justify-center items-center mt-6 mb-20">
        <a href="#" class="hover:underline text-sm md:text-base bg-[#D9D9D9] rounded-full px-6 py-1">Temukan
            Lowongan</a>
        <a href="#" class="hover:underline text-sm md:text-base bg-[#001D86] text-white rounded-full px-6 py-1">Pelajari
            Lebih Lanjut</a>
    </div>
@endsection
@section('content')
    <section class="md:w-4/5" x-data="home" x-init="$store.reactive.filterInit()">
        <div class="bg-red w-full relative">
            <input class="py-3 pl-14 pr-4 border-2 border-[#BDBDBD] w-full rounded-full"
                x-on:keyup="$store.reactive.fetchSearch($el)" placeholder="E.g. Java Developer">
            <img src="assets/magnify.svg" alt="magnify icon" class="absolute top-2 left-3" width="34">
        </div>
        <p x-text="search"></p>
        <div class="my-5">
            <p x-show="$store.reactive.isEmpty()" class="text-center font-xl mt-10" x-text="$store.reactive.placeholder">
            </p>
            <template x-for='data in $store.reactive.result()' :key="data.id">
                <template x-if="data.id">
                    <div
                        class="p-2 my-2 sm:items-center border-2 border-slate-100 flex flex-col sm:flex-row sm:justify-between rounded cursor-pointer hover:bg-slate-50">
                        <div class="flex gap-3">
                            <img :src=" data.gambar" alt="" class="w-28">
                            {{-- <img :src="'storage/lowongan/' + data.gambar" alt="" class="w-28"> --}}
                            <div class="justify-around flex-wrap flex flex-col">
                                <h1 class="text-[#000D3B] font-bold text-lg md:text-2xl" x-text='data.name'></h1>
                                <p class="text-slate-500 text-md" x-text='new Date(data.created_at).toLocaleDateString()'>
                                </p>
                            </div>
                        </div>
                        <a class="py-3 sm:py-1 px-5 mt-5 sm:mt-0 w-full sm:w-fit sm:rounded-md text-center sm:text-right sm:border-2 border-t-[1px] border-[#d8d8d8] sm:border-[#202f66] sm:hover:text-slate-100 sm:hover:bg-[#000D3B]"
                            :href="'lowongan/detail/' + data.id">Detail</a>
                    </div>
                </template>
            </template>
        </div>
    </section>
@endsection

@section('script')
@endsection
@section('sidebar')
    <div class="sidebar">
        <section x-data="home">
            <button class="flex justify-between py-2 bg-slate-200 px-3 rounded-lg w-full"
                x-on:click='sortedBy = !sortedBy'>Urutkan
                Berdasarkan
                <img src="{{ asset('assets/chevron.svg') }}" :class="sortedBy ? 'rotate-180' : ''" alt="arrow">
            </button>
            <ul class="py-2 ml-5 list-none" x-show="sortedBy" x-transition>
                <li class="my-1 text-slate-600"><input x-on:click="$store.reactive.getSorted()" checked type="radio"
                        name="radio" value="terbaru" id="terbaru"> <label for="terbaru">
                        Terbaru</label></li>
                <li class="my-1 text-slate-600"><input x-on:click="$store.reactive.getSorted('terlama')" type="radio"
                        name="radio" value="terlama" id="terlama"> <label for="terlama">
                        Terlama</label></li>
            </ul>
        </section>

        <section class="mt-5" x-data>
            @if (Auth::user()->is_active != 1)
                <button disabled x-on:click="inform('akun anda belum di verifikasi! <br> mohon verfikasi terlebih dahulu')"
                    class="bg-[#000D3B] opacity-60 cursor-not-allowed w-full py-2 px-5 block text-center rounded hover:opacity-50 text-slate-50">Apply
                    Job</button>
            @else
                @if (Auth::user()->is_active === 0)
                    <button disabled
                        class="bg-[#000D3B] opacity-60 cursor-not-allowed w-full py-2 px-5 block text-center rounded hover:opacity-50 text-slate-50">Apply
                        Job</button>
                @endif
                <a href='apply-form' x-on:click='apply = !apply'
                    class="bg-[#000D3B] py-2 px-5 block text-center rounded hover:opacity-80 text-slate-50">Apply
                    Lowongan</a>
                <a href="#" class="my-3 cursor-pointer hover-underline text-center block">Hubungi Kita</a>
            @endif
        </section>
    </div>
@endsection
