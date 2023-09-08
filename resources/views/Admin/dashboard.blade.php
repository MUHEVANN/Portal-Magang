@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl  container-p-y">
            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option selected>Batch</option>

            </select>
            @if (count($allApply) < 1)
                <div class="d-flex justify-content-center mt-3"> Tidak ada Pelamar</div>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>no</th>
                            <th>Nama Pemagang</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Kelompok ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allApply as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if ($item->jabatan === 1)
                                        Ketua
                                    @else
                                        Anggota
                                    @endif
                                </td>
                                <td>{{ $item->kelompok->apply->status }}</td>
                                <td><a href="{{ url('detail-pemagang/' . $item->kelompok->name) }}">Info Kelompok</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
