@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover-underline">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/">Kembali</a>
    </div>
@endsection

@section('content')
    <form action="{{ url('apply-form') }}" class="bg-red lg:w-3/5" method="post" enctype="multipart/form-data">
        @csrf
        <div x-show.transition="current_pos == 1">
            @if ($errors->has('cv_anggota'))
                <div class="alert alert-danger">
                    {{ $errors->first('cv_anggota') }}
                </div>
            @endif
            <label for="tgl-mulai">Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" id="tgl-mulai" class="input-style" id="tipe-magang">

            <label for="tgl-selesai">Tanggal Selesai</label>

            <input type="date" name="tgl_selesai" id="tgl-selesai" class="input-style" id="tipe-magang">
            <button class="py-2 bg-gray-300 px-5 rounded hover:opacity-80 mt-5 my-3 flex justify-end ml-auto text-slate-950"
                x-on:click.prevent="next()">Berikutnya</button>
        </div>

        <div x-show.transition="current_pos == 2">
            @if ($errors->has('sudah-Apply'))
                <div class="alert alert-danger">
                    {{ $errors->first('sudah-Apply') }}
                </div>
            @endif

            @if ($errors->has('sudah-lulus'))
                <div class="alert alert-danger">
                    {{ $errors->first('sudah-lulus') }}
                </div>
            @endif
            <label for="tipe-magang">Tipe Magang</label> <br>
            <select x-model='output' name="tipe_magang" class="py-2 my-3 px-3 w-full mr-3 bg-slate-200 rounded-sm"
                id="tipe-magang">
                <option class="text-slate-500" value="">--Pilih Salah Satu--</option>
                <option value="mandiri">Mandiri</option>
                <option value="kelompok">Kelompok</option>
            </select>

            <label for="alamat">Job Magang Ketua</label> <br>
            <select name="job_magang_ketua" id="">
                <option value="">Pilih Job Magang</option>
                @foreach ($lowongan as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <div x-show="cek_output">
                <button
                    class="bg-[#000D3B] py-2 px-5 hover:underline rounded hover:opacity-80 mt-5 my-3 ml-auto text-slate-50 w-full"
                    x-on:click.prevent='add_field' id='tambah-anggota'>Tambah Anggota</button>

                <template x-for="(ar, idx) in fields">
                    <div class="border-2 border-slate-100 px-2 py-3 mt-5">
                        <span class="hover-underline  block w-fit ml-auto mb-5 cursor-pointer"
                            x-on:click="remove(idx)">remove</span>
                        <label for="name">Name Aggota ke-<span x-text="idx+1"></span></label>
                        <input type="text" name="name[]" class="input-style" id="name"
                            placeholder="E.g. Fulan Nugroho" />
                        @foreach ($errors->get('name') as $error)
                            {{ $error }}
                        @endforeach
                        <label for="email">Email Anggota ke-<span x-text='idx+1'></span> </label>
                        <input type="email" name="email[]" class="input-style" id="email"
                            placeholder="E.g. example@example.com" />
                        @error('email')
                            {{ $message }}
                        @enderror
                        <label for="job">Job Anggota ke-<span x-text='idx+1'></span></label>
                        <select name="job_magang[]" id="job" class="input-style">
                            <option value="">Pilih Job Magang</option>
                            @foreach ($lowongan as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                        @error('job_magang')
                            {{ $message }}
                        @enderror

                        <label for="cv">CV</label>
                        <input type="file" name="cv_anggota[]" class="input-style" id="cv" accept=".pdf" />
                        <p class="text-slate-600">Masukan CV anggotamu dengan dijadikan satu.</p>
                        @error('cv_anggota')
                            {{ $message }}
                        @enderror
                    </div>

                </template>

            </div>


            <div class="flex justify-between items-center">
                <button x-on:click.prevent="previous()"
                    class="py-2 bg-gray-300 px-5 block rounded hover:opacity-80 mt-5 my-3 text-slate-950">Sebelumnya</button>
                <button class="py-2 bg-gray-300 px-5 rounded hover:opacity-80 mt-5 my-3 ml-auto text-slate-950"
                    x-on:click.prevent="next()">Berikutnya</button>
            </div>
        </div>
        <div x-show.transition="current_pos==3">
            <label for="cv">CV</label>
            <input type="file" name="cv_pendaftar" accept=".pdf" class="input-style" id="cv" />
            <p class="text-slate-600">Masukan CV anggotamu dengan dijadikan satu.</p>
            @error('cv_pendaftar')
                {{ $message }}
            @enderror
            <div class="flex justify-between items-center">
                <button x-on:click.prevent="previous()"
                    class="py-2 bg-gray-300 px-5 rounded hover:opacity-80 mt-5 my-3 text-slate-950">Sebelumnya</button>
                <button type="submit"
                    class="bg-[#000D3B] py-2 px-5 rounded hover:opacity-80 mt-5 my-3 ml-auto text-slate-50">Kirim</button>
            </div>
        </div>
    </form>
@endsection

@section('sidebar')
    <div class="sidebar">
        <div class="w-full py-3 rounded-lg h-full bg-blue-900">
            <section class="flex items-center text-white">

                <p class="indicator" :class="current_pos == 1 ? 'active' : 'text-white'">
                    1</p>
                <span :class="current_pos == 1 ? 'font-bold' : ''">Tanggal Magang</span>
            </section>
            <section class="flex items-center text-white">

                <p class="indicator" :class="current_pos == 2 ? 'active' : 'text-white'">
                    2</p>
                <span :class="current_pos == 2 ? 'font-bold' : ''">Anggota Peserta Magang</span>
            </section>
            <section class="flex items-center text-white">

                <p class="indicator" :class="current_pos == 3 ? 'active' : 'text-white'">
                    3</p>
                <span :class="current_pos == 3 ? 'font-bold' : ''">Berkas</span>
            </section>
        </div>
    </div>
@endsection



{{-- @if ($errors->has('sudah-Apply'))
    <div class="alert alert-danger">
            {{ $errors->first('sudah-Apply') }}
        </div>
    @endif

    @if ($errors->has('sudah-lulus'))
        <div class="alert alert-danger">
            {{ $errors->first('sudah-lulus') }}
        </div>
    @endif
    <form action="{{ url('apply-form') }}" id="container" method="post" style="display: flex;flex-direction:column;"
        enctype="multipart/form-data">
        @csrf
        <form-group style="display: flex">
            <label for="name">Job Magang Ketua</label>
            <select name="job_magang_ketua" id="">
                <option value="">Pilih Job Magang</option>
                @foreach ($lowongan as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </form-group>
        <form-group style="display: flex">
            <label for="name">Name Aggota</label>
            <input type="text" name="name[]" />
        </form-group>

        @foreach ($errors->get('name') as $error)
            {{ $error }}
        @endforeach
        <form-group style="display: flex">
            <label for="email">Email Anggota</label>
            <input type="email" name="email[]" />
        </form-group>
        @error('email')
            {{ $message }}
        @enderror
        <form-group style="display: flex">
            <label for="job">Job</label>
            <select name="job_magang[]" id="">
                <option value="">Pilih Job Magang</option>
                @foreach ($lowongan as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </form-group>

        @error('job_magang')
            {{ $message }}
        @enderror
        <div id="field-container">

        </div>
        <button id="tambah-anggota">Tambah Anggota</button>

        <form-group style="display: flex">
            <label for="cv">CV</label>
            <input type="file" name="cv" />
        </form-group>

        @error('cv')
            {{ $message }}
        @enderror
        <button type="submit">Submit</button>
    </form>
    
    <script>
        $(document).ready(function() {
            $('#tambah-anggota').click(function(e) {
                e.preventDefault();
                var inputHtml = `
                    <div id='form-group'>
                    
                    <div style="display: flex">
                        <label for="name">Name Aggota</label>
                        <input type="text" name="name[]" />
                    </div>
                    <div style="display: flex">
                        <label for="email">Email Anggota</label>
                        <input type="email" name="email[]" />
                    </div>
                    <div style="display: flex">
                        <label for="job">Job</label>
                        <select name="job_magang[]">
                            <option value="">Pilih Job Magang</option>
                            @foreach ($lowongan as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="hapus-anggota" type='button'>Hapus</button>
                </div>
                `;

                $('#field-container').append(inputHtml);
            });
            $('#form-group').on('click', '.hapus-anggota', function(e) {
                e.preventDefault();
                $(this).closest('.form-group').remove();
            });

        });
    </script> --}}
