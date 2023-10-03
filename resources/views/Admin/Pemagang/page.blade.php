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
                <select name="filter-job" id="filter-job" class="form-control">
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
            <div class="col-lg-3">
                <select name="filter-tipe-magang" id="filter-tipe-magang" class="form-control">
                    <option value="">Pilih Tipe Magang</option>
                    <option value="mandiri">Mandiri</option>
                    <option value="kelompok">Kelompok</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-danger " id="hapus" type="button" onclick="hapus()" disabled>Hapus</button>
        </div>
        <table class="table table-hover" id="myTable">
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="head-cb"></th>
                    <th>Nama</th>
                    <th>Job</th>
                    <th>Tipe Magang</th>
                    <th>Batch</th>
                    <th>Status</th>
                    <th>kelompok id</th>
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
                order: [
                    [6, 'asc']
                ],
                columnDefs: [{
                    visible: false,
                    targets: 6
                }],
                responsive: true,
                processing: true,
                serverside: true,
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(6, {
                            page: 'current'
                        })
                        .data()
                        .each(function(group, i) {
                            if (last !== group) {
                                $(rows)
                                    .eq(i)
                                    .before(
                                        '<tr class="group" style="background:#f9f9f9;cursor:pointer"><td colspan="7">' +
                                        group +
                                        '</td></tr>'
                                    );

                                last = group;
                            }
                        });
                },
                rowGroup: {
                    dataSrc: 'kelompok.name', // Kolom yang digunakan untuk mengelompokkan data
                    startRender: function(rows, group) {
                        return '<tr class="group"><td colspan="8">' + group + '</td></tr>';
                    },
                    endRender: null
                },
                ajax: 'list-pemagang',
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                    }, {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'lowongan.name',
                        name: 'lowongan.name'
                    },
                    {
                        data: 'apply.tipe_magang',
                        name: 'apply.tipe_magang',

                    },
                    {
                        data: 'apply.carrer.batch',
                        name: 'apply.carrer.batch',

                    },
                    {
                        data: 'apply.status',
                        name: 'apply.status'
                    },
                    {
                        data: 'kelompok.name',
                        name: 'kelompok.name',
                        // render: function(data) {
                        //     return (data !== null) ? 'kelompok ' + data : 'mandiri';
                        // }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
            $('#myTable tbody').on('click', 'tr.group', function() {
                var currentGroup = $(this);
                var nextGroup = currentGroup.nextUntil('tr.group');

                if (nextGroup.is(":visible")) {
                    // Tutup grup
                    currentGroup.data('group-start', 'closed');
                    nextGroup.hide();
                } else {
                    // Buka grup
                    currentGroup.data('group-start', 'open');
                    nextGroup.show();
                }
            });

            // Atur awalnya semua grup ditutup
            $('tr.group').data('group-start', 'closed').next().hide();
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
            $('#filter-tipe-magang').on('change', function() {
                var tipe = $(this).val();
                table.column(3).search(tipe).draw();
            })
            $('body').on('click', '.edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // console.log(id);
                $.ajax({
                    url: '/edit-pemagang/' + id,
                    method: 'GET',
                    success: function(response) {
                        $('#edit-modal').modal('show');
                        $('#name').val(response.result.name);
                        $('#email').val(response.result.email);
                        $('#password').val(response.result.password);
                        var selectedGender = response.result.gender;
                        $('#gender').val(response.result.gender);
                        $('#alamat').val(response.result.alamat);
                        $('#no_hp').val(response.result.no_hp);
                        var selectJob = response.result.job_magang_id;
                        $('#job_magang_id option').each(function() {
                            var optionVal = $(this).val();

                            if (selectJob === parseInt(optionVal)) {
                                $(this).prop('selected', true);
                            } else {
                                $(this).prop('selected', false);
                            }
                        });
                    }
                });
                $("body").off('click', '.update').on('click', '.update', function(e) {
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
            $('#head-cb').on('click', function() {
                if ($('#head-cb').prop('checked') === true) {
                    $('.child-cb').prop('checked', true);
                    $('#hapus').prop('disabled', false);


                } else {
                    $('#hapus').prop('disabled', true);
                    $('.child-cb').prop('checked', false);
                }
            });

            $('#myTable tbody').on('click', '.child-cb', function() {
                if ($(this).prop('checked') === false) {

                    $('#head-cb').prop('checked', false);
                }
                let all_checkbox = $('#myTable tbody .child-cb:checked');
                let active_checkbox = (all_checkbox.length > 0);
                // console.log(all_checkbox.val());
                $('#hapus').prop('disabled', !active_checkbox);
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
                                $('#edit-modal').modal('hide');
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

        function hapus() {
            var checkbox_checked = $('#myTable tbody .child-cb:checked');
            let all_checked = [];
            $.each(checkbox_checked, function(index, value) {
                all_checked.push(value.value);
            });
            console.log(all_checked);
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
                    for (var i = 0; i < all_checked.length; i++) {
                        $.ajax({
                            method: 'DELETE',
                            url: "hapus-pemagang/" + all_checked[i],
                        })
                    }

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
                        title: 'berhasil konfirmasi'
                    });

                    $('#myTable').DataTable().ajax.reload();
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



        }
    </script>
@endsection
