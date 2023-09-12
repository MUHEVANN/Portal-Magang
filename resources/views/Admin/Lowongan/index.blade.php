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
            <button type="button" class="btn btn-primary" id="tambah">
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
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="tambah-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Nama Lowongan</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="desc">Descripsi</label>
                            <input type="text" name="desc" id="desc" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="benefit">Benefit</label>
                            <input type="text" name="benefit" id="benefit" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="kualifikasi">Kualifikasi</label>
                            <input type="text" name="kualifikasi" id="kualifikasi" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="form-control">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" class="close"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary submit">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
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
                        data: 'gambar',
                        name: 'gambar',
                        render: function(data) {
                            return '<img src="storage/lowongan/' + data +
                                '" alt="Image" width="100" height="60" style="object-fit:cover;"/>';

                        }

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

            $('body').on('click', '#tambah', function(e) {
                e.preventDefault();
                $('#tambah-modal').modal('show');

                $('.submit').click(function(e) {
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('name', $('#name').val());
                    formData.append('desc', $('#desc').val());
                    formData.append('benefit', $('#benefit').val());
                    formData.append('kualifikasi', $('#kualifikasi').val());
                    formData.append('gambar', $('#gambar')[0].files[0]);
                    $.ajax({
                        type: "POST",
                        url: "lowongan",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            $('#tambah-modal').modal('hide');
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            table.ajax.reload();
                        }
                    });
                });
            });

            $('body').on('click', '.edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    url: 'lowongan/' + id + '/edit',
                    success: function(response) {
                        $('#tambah-modal').modal('show');
                        $('#name').val(response.name);
                        $('#desc').val(response.desc);
                        $('#kualifikasi').val(response.kualifikasi);
                        $('#benefit').val(response.benefit);
                        $('.submit').off('click');
                        $('.submit').click(function(e) {
                            e.preventDefault();
                            var formData = new FormData();
                            formData.append('name', $('#name').val());
                            formData.append('desc', $('#desc').val());
                            formData.append('benefit', $('#benefit').val());
                            formData.append('kualifikasi', $('#kualifikasi').val());
                            formData.append('gambar', $('#gambar')[0].files[0]);
                            $.ajax({
                                method: 'POST',
                                url: 'lowongans/' + id,
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    $('#tambah-modal').modal('hide');
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Your work has been saved',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    table.ajax.reload();
                                }
                            });
                        });
                    },
                });
                $('.close').click(function() {
                    $('#name').val('');
                    $('#desc').val('');
                    $('#benefit').val('');
                    $('#kualifikasi').val('');

                });
            });
            $('body').on('click', '.hapus', function(e) {
                var id = $(this).data('id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'lowongan/' + id,
                            method: 'DELETE',
                            success: function(response) {
                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                table.ajax.reload();
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your imaginary file is safe :)',
                            'error'
                        )
                    }
                })
            });

        });
    </script>
@endsection
