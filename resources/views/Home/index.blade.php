@extends('Home.layouts.main')

@section('jumbotron')
    <h1 class="text-4xl pt-10 font-bold m-auto font-title w-7/12">DAPATKAN KESEMPATAN MAGANG BERSAMA
        <span class="text-[#001D86] font-title">JETORBIT</span>
    </h1>
    <div class="flex gap-6 justify-center items-center mt-6 mb-20">
        <a href="#" class="hover:underline bg-[#D9D9D9] rounded-full px-6 py-1">Temukan
            Lowongan</a>
        <a href="#" class="hover:underline bg-[#001D86] text-white rounded-full px-6 py-1">Pelajari Lebih
            Lanjut</a>
    </div>
@endsection
@section('content')
    <section class="md:w-4/5" x-data="home">
        <div class="bg-red w-full relative">
            <input class="py-3 pl-14 pr-4 border-2 border-[#BDBDBD] w-full rounded-full" placeholder="E.g. Java Developer">
            <img src="assets/magnify.svg" alt="kaca pembesar svg" class="absolute top-2 left-3" width="34">
        </div>
        <div class="my-5">
            <template x-for='data in $store.ajax.lowongan' :key="data.id">

                <div
                    class="p-2 my-2 pr-5 items-center border-2 border-slate-100 flex justify-between rounded cursor-pointer hover:bg-slate-50">
                    <div class="flex gap-3">
                        <img :src="'storage/lowongan/' + data.gambar" alt="" class="w-28">
                        <div class="justify-around flex-wrap flex flex-col">
                            <h1 class="text-[#000D3B] font-bold text-2xl" x-text='data.name'></h1>
                            <p class="text-slate-500 text-md" x-text='new Date(data.created_at).toLocaleDateString()'></p>
                        </div>
                    </div>
                    <a class="py-1 px-5 rounded-md text-right border-2 border-[#000D3B] hover:text-slate-100 hover:bg-[#000D3B]"
                        :href="'lowongan/detail/' + data.id">Detail</a>
                </div>
            </template>
        </div>
    </section>
@endsection

@section('sidebar')
    <div class="sidebar">
        {{-- <section x-data="home" class="mb-3">
            <button class="flex justify-between py-2 bg-slate-200 px-3 rounded-lg w-full"
                x-on:click='filterType = !filterType'>Filter
                Berdasarkan
                Tipe
                <img src="{{ asset('assets/chevron.svg') }}" :class="filterType ? 'rotate-180' : ''" alt="arrow">
            </button>
            <ul class="py-2 ml-5" x-show='filterType' x-transition>
                <li class="text-slate-600"> <input type="checkbox" name="online" class="p-2 my-2" width="36px"
                        id="online">
                    <label for="online">Online</label>
                </li>
                <li class="text-slate-600"> <input type="checkbox" name="onsite" class="p-2 my-2" width="36px"
                        id="onsite">
                    <label for="onsite">Onsite</label>
                </li>
                <li class="text-slate-600"> <input type="checkbox" name="hybrid" class="p-2 my-2" width="36px"
                        id="hybrid">
                    <label for="hybrid">Hybrid</label>
                </li>
            </ul>
        </section> --}}
        <section x-data="home">
            <button class="flex justify-between py-2 bg-slate-200 px-3 rounded-lg w-full"
                x-on:click='sortedBy = !sortedBy'>Urutkan
                Berdasarkan
                <img src="{{ asset('assets/chevron.svg') }}" :class="sortedBy ? 'rotate-180' : ''" alt="arrow">
            </button>
            <ul class="py-2 ml-5 list-none" x-show="sortedBy" x-transition>
                <li class="my-1 text-slate-600"><input x-on:click="$store.ajax.getSorted()" checked type="radio"
                        name="radio" value="terbaru" id="terbaru"> <label for="terbaru">
                        Terbaru</label></li>
                <li class="my-1 text-slate-600"><input x-on:click="$store.ajax.getSorted('terlama')" type="radio"
                        name="radio" value="terlama" id="terlama"> <label for="terlama">
                        Terlama</label></li>
            </ul>
        </section>

        <section class="mt-5">
            @if (Auth::user()->is_active != 1)
                <button disabled
                    class="bg-[#000D3B] opacity-60 cursor-not-allowed w-full py-2 px-5 block text-center rounded hover:opacity-50 text-slate-50">Apply
                    Job</button>
            @else
                <a href='apply-form' x-on:click='apply = !apply'
                    class="bg-[#000D3B] py-2 px-5 block text-center rounded hover:opacity-80 text-slate-50">Apply
                    Lowongan</a>
                <a href="#" class="my-3 cursor-pointer hover-underline text-center block">Hubungi Kita</a>
            @endif
        </section>
    </div>
@endsection
