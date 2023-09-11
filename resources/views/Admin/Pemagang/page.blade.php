@extends('layouts.dashboard')
@section('content')
    <div class="my-5">
        <div class="row mb-3">
            <div class="col-lg-3">
                <select name="carrer_id" id="filter-batch" class="form-control">
                    <option value="">Pilih Batch</option>
                    @foreach ($carrer as $item)
                        <option value="{{ $item->batch }}">{{ $item->batch }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <select name="carrer_id" id="filter-job" class="form-control">
                    <option value="">Pilih Lowongan</option>
                    @foreach ($job as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <select name="carrer_id" id="filter-status" class="form-control">
                    <option value="">Pilih Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="Lulus">Lulus</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
        </div>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Job</th>
                    <th>Tipe Magang</th>
                    <th>Batch</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="edit-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="name">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="name">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">Pilih Gender</option>
                            <option value="L">L</option>
                            <option value="P">P</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat">alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="no_hp">NO Hp</label>
                        <input type="number" name="no_hp" id="no_hp" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="job_magang_id">Job Magang</label>
                        <select name="job_magang_id" id="job_magang_id" class="form-control">
                            @foreach ($job as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update">Update</button>
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
                ajax: 'list-pemagang',
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
                        data: 'lowongan.name',
                        name: 'lowongan.name'
                    },
                    {
                        data: 'type-magang',
                        name: 'type-magang',

                    },
                    {
                        data: 'kelompok.apply.carrer.batch',
                        name: 'kelompok.apply.carrer.batch',

                    },
                    {
                        data: 'kelompok.apply.status',
                        name: 'kelompok.apply.status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
            $('#filter-batch').on('change', function() {
                var batch = $(this).val();
                table.column(4).search(batch).draw();
            })
            $('#filter-job').on('change', function() {
                var job = $(this).val();
                table.column(2).search(job).draw();
            })
            $('#filter-status').on('change', function() {
                var job = $(this).val();
                table.column(5).search(job).draw();
            })
            $('body').on('click', '.edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: '/edit-pemagang/' + id,
                    method: 'GET',
                    success: function(response) {
                        $('#edit-modal').modal('show');
                        $('#name').val(response.result.name);
                        $('#email').val(response.result.email);
                        $('#password').val(response.result.password);
                        var selectedGender = response.result.gender;
                        $('#gender option').each(function() {
                            var optionValue = $(this).val();

                            if (selectedGender === optionValue) {
                                $(this).prop('selected', true);
                            } else {
                                $(this).prop('selected', false);
                            }
                        });
                        $('#alamat').val(response.result.alamat);
                        $('#no_hp').val(response.result.no_hp);
                        var selectJob = response.result.job_magang_id;
                        $('#job_magang_id option').each(function() {
                            var optionVal = $(this).val();

                            if (selectJob === parseInt(optionVal)) {
                                $(this).prop('selected', true);
                            } else {
                                console.log('cek');
                                $(this).prop('selected', false);
                            }
                        });
                    }
                });
                $(".update").click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: 'edit-pemagang/' + id,
                        method: 'PUT',
                        data: {
                            name: $('#name').val(),
                            email: $('#email').val(),
                            password: $('#password').val(),
                            alamat: $('#alamat').val(),
                            gender: $('#gender').val(),
                            no_hp: $('#no_hp').val(),
                            job_magang_id: $(
                                '#job_magang_id').val(),
                        },
                        success: function(response) {
                            $('#edit-modal').modal('hide');
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            table.ajax.reload();
                            $('#name').val('');
                            $('#email').val('');
                            $('#password').val('');
                            $('#alamat').val('');
                            $('#gender').val('');
                            $('#no_hp').val('');
                            $('#job_magang_id').val('');
                        }
                    });
                });
            });

            $('body').on('click', '.hapus', function(e) {
                e.preventDefault();
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
                            url: 'hapus-pemagang/' + id,
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
