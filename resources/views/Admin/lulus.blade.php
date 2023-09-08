@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="container-xxl container-p-y">
            @foreach ($user as $item)
                @foreach ($item->kelompok->user as $pengguna)
                    {{ $pengguna->name }}
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
