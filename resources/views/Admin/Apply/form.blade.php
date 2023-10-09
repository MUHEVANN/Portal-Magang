@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover-underline w-fit">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/">Kembali</a>
    </div>
@endsection

@section('content')
    <div class="container-width flex-col-reverse">

        <form action="{{ url('apply-form') }}" class="bg-red lg:w-3/5" method="post" enctype="multipart/form-data">
            {{-- <div class="bg-red lg:w-3/5"> --}}
            @csrf
            <div x-show.transition="current_pos == 1">

                {{-- @foreach ($errors->all() as $error)
                    <p class="text-red-500 my-2 font-semibold">{{ $error }}</p>
                @endforeach --}}

                {{-- @foreach ($errors->get('name') as $error)
                    {{ $error }}
                @endforeach
                    @error('job_magang')
                    {{ $message }}
                @enderror

                @if ($errors->has('cv_anggota'))
                    <div class="alert alert-danger">
                        {{ $errors->first('cv_anggota') }}
                    </div>
                @endif

                @if ($errors->has('sudah-Apply'))
                    <div class="alert alert-danger">
                        {{ $errors->first('sudah-Apply') }}
                    </div>
                @endif

                @if ($errors->has('sudah-lulus'))
                    <div class="alert alert-danger">
                        {{ $errors->first('sudah-lulus') }}
                    </div>
                @endif --}}

                <label for="tgl-mulai">Tanggal Mulai</label>
                <input type="date" x-model='start_date' value="{{ old('tgl_mulai') }}" name="tgl_mulai" id="tgl-mulai"
                    class="input-style" id="tipe-magang">

                <label for="tgl-selesai">Tanggal Selesai</label>
                <input type="date" x-model='end_date' value="{{ old('tgl_selesai') }}" name="tgl_selesai"
                    id="tgl-selesai" class="input-style" id="tipe-magang">
                <button
                    class="py-2 bg-gray-300 px-5 rounded hover:opacity-80 mt-5 my-3 flex justify-end ml-auto text-slate-950"
                    x-on:click.prevent="next()">Berikutnya</button>
            </div>

            <div x-show.transition="current_pos == 2">

                <label for="alamat">Job Ketua</label> <br>
                <select name="job_magang_ketua" id="job_ketua" x-model="job_lead" class="input-style">
                    <option value="">Pilih Job Magang</option>
                    @foreach ($lowongan as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <label for="cv">CV Ketua</label>
                <input type="file" name="cv_pendaftar" class="input-style" x-model="cv_lead" id="cv" />
                <p class="text-slate-600">Masukan CV dan Portfolio.</p>
                {{-- indicator Alert --}}
                <li x-show="cv_lead.length > 0" class="flex items-center pb-2 pt-2">
                    <div :class="{
                        'bg-green-200 text-green-700': leaderCV(),
                        'bg-red-200 text-red-700': !leaderCV()
                    }"
                        class=" rounded-full p-1 fill-current ">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="leaderCV()" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                            <path x-show="!leaderCV()" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>

                    <span
                        :class="{
                            'text-green-700': leaderCV(),
                            'text-red-700': !leaderCV()
                        }"
                        class="font-medium text-sm ml-3"
                        x-text="leaderCV() ? 
                    'File sudah Valid' : 'File harus berformat PDF!' "></span>
                </li>
                {{-- end indicator alert --}}


                <hr class="my-5">
                <label for="tipe-magang">Tipe Magang</label> <br>
                <select x-model='tipe_magang' name="tipe_magang" class="input-style" id="tipe-magang">
                    <option class="text-slate-500" value="" selected disabled>--Pilih Salah Satu--</option>
                    <option value="mandiri">Mandiri</option>
                    <option value="kelompok">Kelompok</option>
                </select>

                {{-- <p x-text="fields"></p> --}}
                <div x-show="cek_output">
                    <button :class="fields_len >= 5 ? 'cursor-not-allowed opacity-60' : ''"
                        class="bg-[#000D3B] py-2 px-5 hover:underline rounded hover:opacity-80 mt-5 my-3 ml-auto text-slate-50 w-full"
                        x-on:click.prevent='add_field' id='tambah-anggota'>Tambah Anggota</button>

                    <template x-for="(ar, idx) in fields">
                        <div class="border-2 border-slate-100 px-2 py-3 mt-5">
                            <span class="hover-underline text-red-500 block w-fit ml-auto mb-5 cursor-pointer"
                                x-on:click.prevent="remove(idx)">Hapus</span>
                            <label for="name">Name Aggota ke-<span x-text="idx+1"></span></label>
                            <input type="text" name="name[]" class="input-style" id="name"
                                placeholder="E.g.Fulan Nugroho" x-model="ar.name" />

                            <label for="email">Email Anggota ke-<span x-text='idx+1'></span> </label>
                            <input type="email" name="email[]" x-model="ar.email" class="input-style" id="email"
                                placeholder="E.g. example@example.com" />

                            {{-- indicator Alert --}}
                            <li x-show="ar.email.length > 0" class="flex items-center pb-5">
                                <div :class="{
                                    'bg-green-200 text-green-700': validateEmail(idx),
                                    'bg-red-200 text-red-700': !validateEmail(idx)
                                }"
                                    class="rounded-full p-1 fill-current">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path x-show="validateEmail(idx)" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                        <path x-show="!validateEmail(idx)" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <span
                                    :class="{
                                        'text-green-700': validateEmail(idx),
                                        'text-red-700': !validateEmail(idx)
                                    }"
                                    class="font-medium text-sm ml-3"
                                    x-text="validateEmail(idx) ? 
                                'Email sudah valid' : 'Email belum Valid!' "></span>
                            </li>

                            {{-- end indicator alert --}}

                            <label for="job">Job Anggota ke-<span x-text='idx+1'></span></label>
                            <select name="job_magang[]" id="job" class="input-style" x-model="ar.job">
                                <option value="" disabled selected>-- Pilih Job Magang --</option>
                                @foreach ($lowongan as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            <label for="cv">CV</label>
                            <input type="file" name="cv_anggota[]" class="input-style" id="cv"
                                x-model="ar.cv" />
                            <p class="text-slate-600">Masukan CV dan Portfolio.</p>

                            {{-- indicator Alert --}}
                            <li x-show="ar.cv.length > 0" class="flex items-center pb-5 pt-2">
                                <div :class="{
                                    'bg-green-200 text-green-700': validateCV(idx),
                                    'bg-red-200 text-red-700': !validateCV(idx)
                                }"
                                    class=" rounded-full p-1 fill-current ">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path x-show="validateCV(idx)" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                        <path x-show="!validateCV(idx)" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>

                                <span
                                    :class="{
                                        'text-green-700': validateCV(idx),
                                        'text-red-700': !validateCV(idx)
                                    }"
                                    class="font-medium text-sm ml-3"
                                    x-text="validateCV(idx) ? 
                                'File sudah Valid' : 'File harus berformat PDF!' "></span>
                            </li>
                            {{-- end indicator alert --}}
                        </div>
                    </template>

                </div>
                <div class="flex justify-between items-center">
                    <button x-on:click.prevent="previous()"
                        class="py-2 bg-gray-300 px-5 rounded hover:opacity-80 mt-5 my-3 text-slate-950">Sebelumnya</button>
                    <button x-on:click="next()"
                        class="bg-[#000D3B] py-2 px-5 rounded hover:opacity-80 mt-5 my-3 ml-auto text-slate-50">Kirim</button>
                </div>
            </div>
            {{-- </div> --}}
        </form>
        <div class="sidebar">
            <div class="w-full py-2 rounded-md h-ful bg-[#16265a]">
                <section class="flex items-center text-white">
                    <p class="indicator" :class="current_pos == 1 ? 'active-list' : 'text-white'">
                        1</p>
                    <span :class="current_pos == 1 ? 'font-bold' : ''">Tanggal Magang</span>
                </section>
                <section class="flex items-center text-white">

                    <p class="indicator" :class="current_pos == 2 ? 'active-list' : 'text-white'">
                        2</p>
                    <span :class="current_pos == 2 ? 'font-bold' : ''">Peserta Magang</span>
                </section>
            </div>
        </div>
    </div>
@endsection
