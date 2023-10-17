@extends('layouts.dashboard')
@section('content')
    <div class="card container">
        <div class="my-5">
            <div class="mb-3 d-flex justify-content-end">
                <button type="button" class="btn btn-outline-primary tambah">
                    Tambah
                </button>
            </div>

            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Batch</td>
                        <td>Total Lowongan</td>
                        <td>Peserta</td>
                        <td>Aksi</td>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="batch">Batch</label>
                            <input type="text" name="batch" id="batch" class="form-control">
                            <span class="text-danger" id="error-batch"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary submit">Tambah</button>
                    </div>
                </div>
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
                ajax: '/carrer-batch',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'batch',
                        name: 'batch'
                    }, {
                        data: 'lowongan_count',
                        name: 'lowongan_count'
                    }, {
                        data: 'apply_lulus',
                        name: 'apply_lulus'
                    }, {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('body').on('click', '.tambah', function(e) {
                e.preventDefault();
                $('#tambah-modal').modal('show');
                $('.submit').click(function() {
                    $.ajax({
                        type: "POST",
                        url: "carrer-batch",
                        data: {
                            batch: $('#batch').val()
                        },
                        success: function(response) {
                            if (response.error) {
                                $('#error-batch').text(response.error.batch);
                            } else {
                                $('#batch').val('');
                                $('#tambah-modal').modal('hide');
                                const Toast = Swal.mixin({
                                    width: 400,
                                    padding: 18,
                                    toast: true,
                                    position: 'bottom-end',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter',
                                            Swal.stopTimer)
                                        toast.addEventListener('mouseleave',
                                            Swal.resumeTimer)
                                    }
                                })

                                Toast.fire({

                                    icon: 'success',
                                    title: response.success
                                });
                                table.ajax.reload();
                            }
                        }
                    });
                });
            });

            $('body').on('click', '.edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "carrer-batch/" + id + '/edit',
                    success: function(response) {
                        $('#tambah-modal').modal('show');
                        $('#batch').val(response.batch);
                    }
                });
                $('.submit').off('click');
                $('.submit').click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "PUT",
                        url: "carrer-batch/" + id,
                        data: {
                            batch: $('#batch').val()
                        },
                        success: function(response) {
                            $('#tambah-modal').modal('hide');
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            table.ajax.reload();
                        }
                    });
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
                            url: 'carrer-batch/' + id,
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
