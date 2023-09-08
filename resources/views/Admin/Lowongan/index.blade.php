@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl container-p-y">
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                    Tambah
                </button>
                <select name="" id="">
                    <option value="">Batch</option>
                </select>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lowongan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @foreach ($lowongan as $item)
                    <tbody>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
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
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('lowongan') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Name</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name"
                                    name="name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Deskripsi</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name"
                                    name="desc" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Benefit</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name"
                                    name="benefit" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Kualifikasi</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name"
                                    name="kualifikasi" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">gambar</label>
                                <input type="file" id="nameBasic" class="form-control" placeholder="Enter Name"
                                    name="gambar" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary save">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.save').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: {{ url('lowongan') }},
                    method: 'POST',
                    data: {}
                });
            });
        });
    </script>
@endsection
