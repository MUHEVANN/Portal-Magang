@extends('layouts.dashboard')
@section('content')
    <table class="table table-stiped " id="myTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Jabatan</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#myTable').DataTable({
                processing: true,
                serverside: true,
                ajax: '/apply-user',
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'name',
                    name: 'name',
                }, {
                    data: 'kelompok.apply.status',
                    name: 'kelompok.apply.status',
                }, {
                    data: 'jabatan',
                    name: 'jabatan',
                    render: function(data) {
                        return (data === 0) ? 'Anggota' : 'Ketua';
                    }
                }, {
                    data: 'action',
                    name: 'action',
                }]
            });
        });
    </script>
@endsection
