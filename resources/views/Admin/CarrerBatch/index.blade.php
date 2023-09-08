@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl container-p-y">
            <div class="d-flex justify-content-end">

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
                    Tambah
                </button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Batch</td>
                        <td>Total Lowongan</td>
                        <td>Peserta</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                @foreach ($carrer as $item)
                    <tbody>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->batch }}</td>
                            <td>{{ $item->lowongan_count }}</td>
                            @php
                                $totalUsers = 0;
                            @endphp

                            @foreach ($item->lowongan as $lowongan)
                                @php
                                    $totalUsers += count($lowongan->user);
                                @endphp
                            @endforeach

                            <td>
                                {{ $totalUsers }}
                            </td>
                            <td>
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#hapus{{ $item->id }}" style="color:red;">
                                    Hapus
                                </button>
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $item->id }}" style="color:blue;">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    {{-- modal hapus --}}
                    <div class="modal fade" id="hapus{{ $item->id }}" aria-labelledby="modalToggleLabel" tabindex="-1"
                        style="display: none" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalToggleLabel">Hapus Batch</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">Yakin ingin menghapus <b>{{ $item->batch }}</b>?</div>
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
                                    <form action="{{ url('carrer-batch/' . $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Batch</label>
                                                <input type="text" id="nameBasic name" class="form-control"
                                                    placeholder="Enter Name" name="batch" value="{{ $item->batch }}" />
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
                    {{-- modal tambah --}}
                    <div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Batch</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('carrer-batch') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Batch</label>
                                                <input type="text" id="nameBasic name" class="form-control"
                                                    placeholder="Enter Name" name="batch" />
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
@endsection
