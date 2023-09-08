@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl container-p-y">
            <form action="{{ url('lowongan/' . $lowongan->id) }}" method="post" style="display: flex;flex-direction:column;"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <form-group style="display: flex;flex-direction:column;">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Lowongan</label>
                    <input type="text" class="form-control" id="basic-default-name" name="name"
                        value="{{ $lowongan->name }}" />
                </form-group>
                @error('name')
                    {{ $message }}
                @enderror
                <form-group style="display: flex;flex-direction:column;">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Deskripsi</label>
                    <input class="form-control" type="text" name="desc" value="{{ $lowongan->desc }}" />
                </form-group>
                @error('desc')
                    {{ $message }}
                @enderror
                <form-group style="display: flex;flex-direction:column;">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Benefit</label>
                    <input class="form-control" type="text" name="benefit" value="{{ $lowongan->benefit }}" />
                </form-group>
                @error('benefit')
                    {{ $message }}
                @enderror
                <form-group style="display: flex;flex-direction:column;">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Kualifikasi</label>
                    <input class="form-control" type="text" name="kualifikasi" value="{{ $lowongan->kualifikasi }}" />
                </form-group>
                @error('kualifikasi')
                    {{ $message }}
                @enderror

                <form-group style="display: flex;flex-direction:column;">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Gambar</label>
                    <input class="form-control" type="file" name="gambar" value="{{ $lowongan->gambar }}" />
                </form-group>
                @error('gambar')
                    {{ $message }}
                @enderror
                <div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
