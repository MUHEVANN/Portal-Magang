@extends('layouts.dashboard')
@section('content')
    <div class="my-3">
        <button type="button" class="btn btn-primary tambah">
            Tambah
        </button>
    </div>
    <table class="table table-stiped" id="myTable">
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpan">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="hapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-hapus"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger button-hapus">Hapus</button>
                </div>
            </div>
        </div>
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
@endsection
