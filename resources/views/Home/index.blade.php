@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl container-p-y">
            <div class="d-flex justify-content-end gap-2">
                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                    Tambah
                </button> --}}
                <select name="" id="">
                    <option value="">Batch</option>
                </select>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Job</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
                @foreach ($lowongan as $item)
                    <tbody>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->desc }}</td>
                            <td>{{ $item->gambar }}</td>
                            {{-- <td>
                                <form action="{{ url('lowongan/' . $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn " style="color:red;">
                                        Hapus
                                    </button>
                                </form>
                                <button class="btn ">
                                    <a href="{{ url('lowongan/' . $item->id . '/edit') }}">Edit</a>
                                </button>
                            </td> --}}
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
@endsection
