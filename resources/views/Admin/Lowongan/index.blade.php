@extends('layouts.dashboard')
@section('content')
    <div class="my-5">

        <div class="d-flex justify-content-end gap-2 mb-3">
            <div class="col-lg-2">
                <select name="batch" id="select-batch" class="form-control">
                    <option value="">Pilih Batch</option>
                    @foreach ($carrer as $item)
                        <option value="{{ $item->id }}">{{ $item->batch }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                Tambah
            </button>
        </div>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lowongan</th>
                    <th>desc</th>
                    <th>Benefit</th>
                    <th>Kualifikasi</th>
                    <th>Aksi</th>
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
                ajax: {
                    url: 'lowongan',
                    data: function(d) {
                        d.batch_id = $('#select-batch').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'desc',
                        name: 'desc'
                    },
                    {
                        data: 'benefit',
                        name: 'benefit'
                    },
                    {
                        data: 'kualifikasi',
                        name: 'kualifikasi'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('#select-batch').on('change', function(e) {
                e.preventDefault();
                table.ajax.reload();

            });
        });
    </script>
@endsection
