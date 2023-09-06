@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl  container-p-y">
            <table class="table">
                <thead>
                    <tr>

                        <th>no</th>
                        <th>Nama Pemagang</th>
                        <th>Apply Lowongan</th>
                        <th>Kelompok</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Detail Kelompok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allApply as $item)
                        @foreach ($item->kelompok->user as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>{{ $item->lowongan->name }}</td>
                                <td>{{ $item->kelompok->name }}</td>
                                <td>
                                    @if ($user->jabatan === 1)
                                        Ketua
                                    @else
                                        Anggota
                                    @endif
                                </td>
                                <td>
                                    {{ $item->status }}
                                </td>
                                <td><a href="{{ url('detail-pemagang/' . $item->kelompok->name) }}">Cek Kelompok</a>
                                </td>
                            </tr>
                        @endforeach
                        {{-- <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->apply->lowongan->name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @if ($item->user->jabatan === 1)
                                    Ketua
                                @endif
                            </td>
                            <td>{{ $item->konfirmasi }}</td>
                            <td><a href="{{ url('detail-pemagang/' . $item->user->nama_kelompok) }}">Cek Kelompok</a></td>
                        </tr> --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
