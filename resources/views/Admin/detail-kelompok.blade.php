@extends('layouts.dashboard')
@section('content')
    <div class="my-5">
        <table class="table table-stiped" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Jabatan</th>
                    <th>CV</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>


@section('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = '{{ $kelompok->id }}';
            $('#myTable').DataTable({
                processing: true,
                serverside: true,
                ajax: '/apply-user-get-detail/' + id,
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'name',
                    name: 'name',
                }, {
                    data: 'apply.status',
                    name: 'apply.status',
                }, {
                    data: 'jabatan',
                    name: 'jabatan',
                    render: function(data) {
                        return (data === 0) ? 'Anggota' : 'Ketua';
                    }
                }, {
                    data: 'cv_user',
                    name: 'cv_user',
                }, {
                    data: 'action',
                    name: 'action',
                }]
            });
        });
    </script>
@endsection
@endsection
