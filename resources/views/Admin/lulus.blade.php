@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl container-p-y">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemagang</th>
                        <th>Batch</th>
                        <th>Job</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                        @foreach ($item->kelompok->user as $anggota)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $anggota->name }}
                                </td>
                                <td>
                                    {{ $anggota->lowongan->name }}
                                </td>
                                <td>{{ $item->carrer->batch }}</td>
                                <td>{{ $item->status }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
