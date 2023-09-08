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
                        <th>desc</th>
                        <th>Benefit</th>
                        <th>Kualifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @foreach ($lowongan as $item)
                    <tbody>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->desc }}</td>
                            <td>{{ $item->benefit }}</td>
                            <td>{{ $item->kualifikasi }}</td>
                            <td>

                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#hapus{{ $item->id }}" style="color:red;">
                                    Hapus
                                </button>
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $item->id }}" style="color:blue;">
                                    Edit
                                </button>
                                {{-- <button class="btn ">
                                    <a href="{{ url('lowongan/' . $item->id . '/edit') }}">Edit</a>
                                </button> --}}
                            </td>
                        </tr>
                    </tbody>
                    {{-- modal hapus --}}
                    <div class="modal fade" id="hapus{{ $item->id }}" aria-labelledby="modalToggleLabel" tabindex="-1"
                        style="display: none" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalToggleLabel">Hapus Lowongan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">Yakin ingin menghapus <b>{{ $item->name }}</b>?</div>
                                <div class="modal-footer">
                                    <form action="{{ url('lowongan/' . $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- modal Edit --}}
                    <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('lowongan/' . $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Name</label>
                                                <input type="text" id="nameBasic name" class="form-control"
                                                    placeholder="Enter Name" name="name" value="{{ $item->name }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Deskripsi</label>
                                                <input type="text" id="nameBasic desc" class="form-control"
                                                    placeholder="Enter Name" name="desc" value="{{ $item->desc }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Benefit</label>
                                                <input type="text" id="nameBasic benfit" class="form-control"
                                                    placeholder="Enter Name" name="benefit" value="{{ $item->benefit }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Kualifikasi</label>
                                                <input type="text" id="nameBasic kualifikasi" class="form-control"
                                                    placeholder="Enter Name" name="kualifikasi"
                                                    value="{{ $item->kualifikasi }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">gambar</label>
                                                <input type="file" id="nameBasic gambar" class="form-control"
                                                    placeholder="Enter Name" name="gambar"
                                                    value="{{ $item->gambar }}" />
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="submit">Save changes</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </table>
        </div>
    </div>
    {{-- modal tambah --}}
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('lowongan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Name</label>
                                <input type="text" id="nameBasic name" class="form-control" placeholder="Enter Name"
                                    name="name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Deskripsi</label>
                                <input type="text" id="nameBasic desc" class="form-control" placeholder="Enter Name"
                                    name="desc" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Benefit</label>
                                <input type="text" id="nameBasic benfit" class="form-control"
                                    placeholder="Enter Name" name="benefit" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Kualifikasi</label>
                                <input type="text" id="nameBasic kualifikasi" class="form-control"
                                    placeholder="Enter Name" name="kualifikasi" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">gambar</label>
                                <input type="file" id="nameBasic gambar" class="form-control"
                                    placeholder="Enter Name" name="gambar" />
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
