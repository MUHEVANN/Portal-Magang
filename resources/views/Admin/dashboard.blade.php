@extends('layouts.dashboard')
@section('content')
    <div class="my-5">
        <div class="mb-3 d-flex justify-content-end">
            <div class="col-3">
                <select name="" id="select-tipe" class="form-control">
                    <option value="">Tipe Magang</option>
                    <option value="mandiri">Mandiri</option>
                    <option value="kelompok">Kelompok</option>
                </select>
            </div>
        </div>
        <table class="table table-stiped " id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>cv</th>
                    <th>Job Magang</th>
                    <th>Tipe Magang</th>
                    <th>Status</th>
                    <th>Jabatan</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#myTable').DataTable({
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
                    data: 'apply.cv_user',
                    name: 'apply.cv_user',
                    render: function(data) {
                        return "<a href='storage/cv/" + data + "'>" + data +
                            "</a>";
                    }
                }, {
                    data: 'lowongan.name',
                    name: 'lowongan.name',
                }, {
                    data: 'apply.tipe_magang',
                    name: 'apply.tipe_magang',
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
                    data: 'action',
                    name: 'action',
                }]
            });

            $('#select-tipe').on('change', function() {
                var tipe = $(this).val();
                table.column(4).search(tipe).draw()
            });
        });
    </script>
@endsection
