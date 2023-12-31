@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl  container-p-y">
            @foreach ($kelompok as $item)
                ID Kelompok : {{ $item->name }}
                <table class="table">
                    <thead>
                        <tr>
                            <th>no</th>
                            <th>Nama Aggota</th>
                            <th>Job Magang</th>
                            <th>Cv</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item->user as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->lowongan->name }}</td>
                                <td><a href="{{ asset('storage/cv/' . $item->apply->cv_user) }}">Cv</a></td>
                                <td>
                                    @if ($user->jabatan === 1)
                                        Ketua
                                    @else
                                        Anggota
                                    @endif
                                </td>
                                <td>{{ $item->apply->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex mt-2 gap-2"><a href="{{ url('apply-status-konfirm/' . $item->apply->id) }}">Konfimasi</a><a
                        href="{{ url('apply-status-reject/' . $item->apply->id) }}">Tolak</a></div>
        </div>
    </div>
    @endforeach
@endsection
