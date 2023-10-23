@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover-underline w-fit">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/" class="block">Kembali</a>
    </div>
@endsection
@section('content')
    <div class="container-width flex-col" x-data="dashboard">
        <div class="w-full">
            <h1 class="text-slate-750 text-2xl block mb-5">Halo, <span class="font-bold">{{ Auth::user()->name }}</span></h1>

            <h1 x-text="message" class="text-center font-normal text-slate-500"></h1>
            <!-- component -->
            <div class="overflow-hidden rounded-md border border-gray-200 shadow-sm m-5" x-show="!message">
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Job</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Tanggal Mulai</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Tanggal Selesai</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Batch</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">CV</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 border-t border-gray-100">

                        <template x-for="item in dashboardUser">
                            <tr class="hover:bg-gray-50">
                                <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                                    <p x-text="item.lowongan.name"></p>
                                </th>
                                <td class="px-6 py-4">
                                    <p x-text="item.tgl_mulai"></p>
                                </td>
                                <td class="px-6 py-4">
                                    <p x-text="item.tgl_selesai"></p>
                                </td>
                                <td class="px-6 py-4">
                                    <p x-text='item.carrer.batch'></p>
                                </td>
                                <td class="px-6 py-4">

                                    <a x-text="item.cv_user" :href="'./storage/cv/' + item.cv_user"
                                        class="inline-flex items-center gap-1 rounded-full bg-violet-50 px-2 py-1 text-xs font-semibold text-violet-600">
                                        Develop
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        :class="{
                                            'bg-red-50 text-red-600': statusCheck(item.status),
                                            'bg-green-50 text-green-600': !statusCheck(item.status)
                                        }"
                                        class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold"
                                        x-text="item.status">
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                {{-- <iframe allow="camera; microphone; display-capture; fullscreen; clipboard-read; clipboard-write; autoplay"
                    src="https://sfu.mirotalk.com/newroom" style="height: 100vh; width: 100vw; border: 0px;"></iframe> --}}
            </div>
        </div>
    </div>
@endsection
