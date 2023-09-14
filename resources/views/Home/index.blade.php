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
    <section class="md:w-4/5" x-data="{
        search: '',
        datas: {{ $lowongan }},
    
        get filterDatas() {
            return this.datas;
        }
    }">
        <div class="bg-red w-full relative">
            <input x-model="search" class="py-3 pl-14 pr-4 border-2 border-[#BDBDBD] w-full rounded-full"
                placeholder="E.g. Java Developer">
            <img src="assets/magnify.svg" alt="kaca pembesar svg" class="absolute top-2 left-3" width="34">
        </div>
        <div class="my-5">
            <template x-for='data in filterDatas' :key="data">
                <div
                    class="p-2 my-2 pr-5 items-center border-2 border-slate-100 flex justify-between rounded cursor-pointer hover:bg-slate-50">
                    <div class="flex gap-3">
                        <img :src="data.gambar" alt="" class="w-28">
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
    <section x-data="{ open: false }" class="mb-3">
        <button class="flex justify-between py-2 bg-slate-200 px-3 rounded-lg w-full" x-on:click='open = !open'>Filter
            Berdasarkan
            Tipe
            <img src="{{ asset('assets/chevron.svg') }}" :class="open ? 'rotate-180' : ''" alt="arrow">
        </button>
        <ul class="py-2 ml-5" x-show='open' x-transition>
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
    </section>
    <section x-data="{ open: false }">
        <button class="flex justify-between py-2 bg-slate-200 px-3 rounded-lg w-full" x-on:click='open = !open'>Urutkan
            Berdasarkan
            <img src="{{ asset('assets/chevron.svg') }}" :class="open ? 'rotate-180' : ''" alt="arrow">
        </button>
        <ul class="py-2 ml-5" x-show="open" x-transition>
            <li class="my-1"> <input type="radio" name="radio" id="terbaru"> <label for="terbaru">
                    Terbaru</label></li>
            <li class="my-1"> <input type="radio" name="radio" id="terlama"> <label for="terlama">
                    Terlama</label></li>
        </ul>
    </section>

    <section class="mt-5">
        <a href='apply-form' x-on:click='apply = !apply'
            class="bg-[#000D3B] py-2 px-5 hover:underline block text-center rounded hover:opacity-80 text-slate-50">Apply
            Lowongan</a>
        <a href="#" class="my-3 cursor-pointer hover:underline text-center block">Hubungi Kita</a>
        {{-- <div class="mt-8">
            <p class="text-slate-700">Dipublis pada</p>
            <h3 class="font-bold text-md">{{ $lowongan->created_at }}</h3>
        </div> --}}
    </section>
@endsection
