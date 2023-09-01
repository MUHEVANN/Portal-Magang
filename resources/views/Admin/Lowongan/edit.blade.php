<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ url('lowongan/' . $lowongan->id) }}" method="post" style="display: flex;flex-direction:column;"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <form-group style="display: flex">
            <label for="name">Nama Lowongan</label>
            <input type="text" name="name" value="{{ $lowongan->name }}" />
        </form-group>
        @error('name')
            {{ $message }}
        @enderror
        <form-group style="display: flex">
            <label for="desc">Deskripsi</label>
            <input type="text" name="desc" value="{{ $lowongan->desc }}" />
        </form-group>
        @error('desc')
            {{ $message }}
        @enderror
        <form-group style="display: flex">
            <label for="benefit">Benefit</label>
            <input type="text" name="benefit" value="{{ $lowongan->benefit }}" />
        </form-group>
        @error('benefit')
            {{ $message }}
        @enderror
        <form-group style="display: flex">
            <label for="kualifikasi">Kualifikasi</label>
            <input type="text" name="kualifikasi" value="{{ $lowongan->kualifikasi }}" />
        </form-group>
        @error('kualifikasi')
            {{ $message }}
        @enderror
        <form-group style="display: flex">
            <label for="max_applay">Maximum Apply</label>
            <input type="date" name="max_applay" value="{{ $lowongan->max_applay }}" />
        </form-group>
        @error('max_applay')
            {{ $message }}
        @enderror
        <form-group style="display: flex">
            <label for="gambar">Gambar</label>
            <input type="file" name="gambar" />
        </form-group>

        @error('gambar')
            {{ $message }}
        @enderror
        <button type="submit">Submit</button>
    </form>
</body>

</html>
