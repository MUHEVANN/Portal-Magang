@extends('Home.layouts.main')

@section('jumbotron')
    <h1
        class="text-3xl md:text-5xl tracking-wide md:leading-tight sm:text-4xl pt-10 font-extrabold text-neutral-800 m-auto font-title w-10/12 sm:w-9/12 md:w-7/12">
        Dapatkan kesempatan magang bersama
        <span class="text-[#001D86] font-title">Jetorbit</span>
    </h1>
    <div class="flex gap-6 justify-center items-center my-10">
        <a href="#" class="font-title text-xs sm:text-sm bg-[#001D86] text-white rounded-full px-6 py-1">Pelajari
            Lebih Lanjut</a>
    </div>
@endsection
@section('content')
    <div class="flex-col-reverse container-width">
        <section class="md:w-4/5" x-data="home" x-init="$store.reactive.filterInit()">
            <div class="bg-red w-full relative">
                <input
                    class="py-3 pl-14 pr-4 border-[2px] border-[#e6e6e6] focus:outline-none focus:border-slate-500 w-full rounded-lg"
                    x-on:keyup="$store.reactive.fetchSearch($el)" placeholder="E.g. Java Developer">
                <img src="assets/magnify.svg" alt="magnify icon" class=" absolute top-4 left-5" width="20">
            </div>
            <p x-text="search"></p>
            <div x-show="$store.reactive.isEmpty()" class="flex justify-center font-xl mt-10">
                <span x-html="$store.reactive.placeholder" class="flex flex-col items-center gap-y-3"></span>
            </div>
            <div class="my-5 grid sml:grid-cols-2 grid-cols-1 gap-6">
                <template x-for='data in $store.reactive.result()' :key="data.id">
                    <template x-if="data.id">
                        <a :href="'lowongan/detail/' + data.id"
                            class="sm:items-center w-full col-span-1 bg-white hover:border-blue-500 hover:shadow border-[1px] border-slate-300 flex flex-row justify-between rounded-md cursor-pointer hover:bg-blue-50">
                            <div class="flex flex-col w-full h-full justify-between">
                                <span class="bg-slate-200 overflow-hidden transition rounded-t-md sml:w-full">
                                    <template x-if="imageType(data.gambar)">
                                        <img :src="data.gambar" :alt="data.gambar"
                                            class="transition hover:scale-110">
                                    </template>
                                    <template x-if="!imageType(data.gambar)">
                                        <img :src="'storage/lowongan/' + data.gambar" :alt="data.gambar"
                                            class="transition hover:scale-110">
                                    </template>
                                </span>
                                <div class="p-3">
                                    <h1 class="text-[#000D3B] font-bold text-lg md:text-1xl mb-3" x-text='data.name'></h1>
                                    <p x-html="sortParagraph(data.desc)" class="w-full text-gray-500 mb-3 text-sm"></p>

                                    <div class="flex justify-between w-full mt-3 sml:mt-0 gap-2 sm:items-center">
                                        <p class="text-green-600 text-sm text-limit" x-text='elapsedTime(data.updated_at)'>
                                        </p>
                                        <p x-text="dueTime(data.deadline)" class="text-sm text-slate-400 text-limit"></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </template>
                </template>
            </div>
            <template x-if="$store.reactive.paginate()">
                <nav class="flex justify-center mt-5 w-full">
                    <ul class="pagination-list">
                        <li x-on:click="$store.reactive.prevPage()">
                            <p
                                class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-500">
                                <img src="{{ asset('assets/chevron.svg') }}" class="rotate-90 opacity-50 w-5"
                                    alt="">
                            </p>
                        </li>
                        <template x-for="item in $store.reactive.paginate()" :key="item">
                            <li>
                                <p x-on:click="$store.reactive.selectPage(item)"
                                    :class="{ 'active': item == $store.reactive.curr_select }"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-500 "
                                    x-text="setNumPage(item)"></p>
                            </li>
                        </template>
                        <li x-on:click="$store.reactive.nextPage()">
                            <p
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-500 ">
                                <img src="{{ asset('assets/chevron.svg') }}" class="-rotate-90 opacity-50 w-5"
                                    alt="">
                            </p>
                        </li>
                    </ul>
                </nav>
            </template>
        </section>

        <div class="sidebar">
            <section x-data="home">
                <button class="flex justify-between py-2 bg-slate-200 px-3 transition rounded w-full"
                    x-on:click='sortedBy = !sortedBy'>Urutkan
                    Berdasarkan
                    <img src="{{ asset('assets/chevron.svg') }}" class="transition" :class="sortedBy ? 'rotate-180' : ''"
                        alt="arrow">
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
                @if (!Auth::check())
                    <button disabled
                        x-on:click="inform('akun anda belum di verifikasi! <br> mohon verfikasi terlebih dahulu')"
                        class="bg-[#000D3B] opacity-60 cursor-not-allowed w-full py-2 px-5 block text-center rounded hover:opacity-50 text-slate-50">Lamar
                        Magang</button>
                @else
                    @if (Auth::user()->is_active === 0)
                        <button disabled
                            class="bg-[#000D3B] opacity-60 cursor-not-allowed w-full py-2 px-5 block text-center rounded hover:opacity-50 text-slate-50">Lamar
                            Magang</button>
                    @endif
                    <a href='apply-form'
                        class="bg-[#000D3B] py-2 px-5 block text-center rounded hover:opacity-80 text-slate-50">Lamar
                        Magang</a>
                @endif
                <a href="#" class="my-3 cursor-pointer hover-underline text-center block">Hubungi Kita</a>
            </section>
        </div>
    </div>
@endsection
@section('script')
@endsection
