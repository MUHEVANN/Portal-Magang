@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl  container-p-y">
            Nama Kelompok : {{ $kelompok[0]->nama_kelompok }}
            <table class="table">
                <thead>
                    <tr>
                        <th>no</th>
                        <th>Nama Aggota</th>
                        <th>Cv</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelompok as $item)
                        @foreach ($item->user as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td><a href="{{ asset('cv/' . $item->apply->cv_user) }}">Cv</a></td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
