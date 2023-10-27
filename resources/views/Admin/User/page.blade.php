@extends('layouts.dashboard')
@section('content')
    <div class="card container">
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
            <table class="display nowrap table table-hover" id="myTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" id="head-cb"></th>
                        <th>Name</th>
                        <th>Job</th>
                        <th>No Hp</th>
                        <th>Tipe Magang</th>
                        <th>Jabatan</th>
                        <th>Batch</th>
                        <th>Status</th>
                        <th>Cv</th>
                        <th>Kelompok Id</th>
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
                            <div id="error-name" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="name">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <div id="error-email" class="text-danger"></div>
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
                        <h2 class="fs-5">-- Data Apply --</h2>
                        {{-- <input type="text" id="batch" name="batch" class="form-control"> --}}
                        <div class="mb-3">
                            <label for="name">Batch</label>
                            <select name="batch" id="batch" class="form-control">
                                <option value="">Pilih Batch</option>
                                @foreach ($carrer as $item)
                                    <option value="{{ $item->id }}">{{ $item->batch }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="job_magang_id">Job Magang</label>
                            <select name="job_magang_id" id="job_magang_id" class="form-control">
                                <option value="">Pilih Job</option>
                                {{-- @foreach ($job as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach --}}
                            </select>
                            <div id="error-job_magang_id" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_mulai">Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai">Tanggal Selesai</label>
                            <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary update">Update</button>
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
                order: [
                    [9, 'asc']
                ],
                columnDefs: [{
                    visible: false,
                    targets: 9
                }],
                fixedHeader: true,
                responsive: true,
                processing: true,
                serverside: true,
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(9, {
                            page: 'current'
                        })
                        .data()
                        .each(function(group, i) {
                            var column = table.columns().count();

                            if (last !== group) {
                                $(rows)
                                    .eq(i)
                                    .before(
                                        '<tr class="group" style="background:#f9f9f9;cursor:pointer"><td colspan="10">' +
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
                        return '<tr class="group"><td colspan="9">' + group + '</td></tr>';
                    },
                    endRender: null
                },
                ajax: 'list-pemagang',
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'lowongan.name',
                        name: 'lowongan.name'
                    },
                    {
                        data: 'user.no_hp',
                        name: 'user.no_hp'
                    },
                    {
                        data: 'tipe_magang',
                        name: 'tipe_magang'
                    },
                    {
                        data: 'user.jabatan',
                        name: 'user.jabatan',
                        render: function(data) {
                            return data === 1 ? "ketua" : "anggota"
                        }
                    },
                    {
                        data: 'carrer.batch',
                        name: 'carrer.batch'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'cv_user',
                        name: 'cv_user',
                        render: function(data) {
                            return "<a href='storage/cv/" + data + "'>" + data + "</a>"
                        }
                    },
                    {
                        data: 'kelompok.name',
                        name: 'kelompok.name'
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
                table.column(6).search(batch).draw();
            })
            $('#filter-job').on('change', function() {
                var job = $(this).val();
                table.column(2).search(job).draw();
            })
            $('#filter-status').on('change', function() {
                var job = $(this).val();
                table.column(7).search(job).draw();
            })
            $('#filter-tipe-magang').on('change', function() {
                var tipe = $(this).val();
                table.column(4).search(tipe).draw();
            })
            $('body').on('click', '.edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: '/edit-pemagang/' + id,

                    method: 'GET',
                    success: function(response) {
                        console.log(response.result.apply.job_magang_id);
                        $('#edit-modal').modal('show');
                        $('#name').val(response.result.user.name);
                        $('#email').val(response.result.user.email);
                        $('#password').val(response.result.user.password);
                        var selectedGender = response.result.user.gender;
                        $('#gender').val(response.result.user.gender);
                        $('#alamat').val(response.result.user.alamat);
                        $('#no_hp').val(response.result.user.no_hp);
                        $('#tgl_mulai').val(response.result.apply.tgl_mulai);
                        $('#tgl_selesai').val(response.result.apply.tgl_selesai);
                        var selectedBatchId = response.result.apply.carrer_id;
                        $('#job_magang_id').empty();
                        var selectJob = response.result.apply.job_magang_id;
                        $.ajax({
                            url: 'by-batch/' + selectedBatchId,
                            method: 'GET',
                            success: function(response) {
                                // console.log(response.data[0].name);
                                var selectElement = $('#job_magang_id');
                                // Mengisi opsi elemen select dengan data dari server
                                $.each(response.data, function(key,
                                    value) {
                                    selectElement.append(
                                        '<option value="' +
                                        value.id + '">' +
                                        value.name +
                                        '</option>');
                                    console.log(selectJob)
                                    $('#job_magang_id option').each(
                                        function() {
                                            var optionVal = $(this)
                                                .val();

                                            if (selectJob === parseInt(
                                                    optionVal)) {
                                                $(this).prop('selected',
                                                    true);
                                            } else {
                                                $(this).prop('selected',
                                                    false);
                                            }
                                        });
                                });
                            }
                        });
                        var selectBatch = response.result.apply.carrer_id;
                        $('#batch').val(selectBatch);

                        // console.log(selectJob);
                        $('#job_magang_id').val(selectJob);
                        $('#batch').on('change', function() {
                            var selectedBatchId = $(this).val();
                            // Selanjutnya, Anda dapat mengirim permintaan AJAX untuk mendapatkan data lowongan sesuai batch ID yang dipilih.
                            $.ajax({
                                url: 'by-batch/' + selectedBatchId,
                                method: 'GET',
                                success: function(response) {
                                    console.log(response.data);
                                    var selectElement = $('#job_magang_id');
                                    selectElement
                                        .empty(); // Mengosongkan elemen select

                                    // Menambahkan opsi default
                                    selectElement.append(
                                        '<option value="">Pilih Job</option>'
                                    );

                                    // Mengisi opsi elemen select dengan data dari server
                                    $.each(response.data, function(key,
                                        value) {
                                        selectElement.append(
                                            '<option value="' +
                                            value.id + '">' +
                                            value.name +
                                            '</option>');
                                    });
                                }
                            });
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
                            carrer_id: $('#batch').val(),
                            tgl_mulai: $('#tgl_mulai').val(),
                            tgl_selesai: $('#tgl_selesai').val(),
                        },
                        success: function(response) {

                            if (response.error) {
                                $('#error-job_magang_id').text(response.error
                                    .job_magang_id);
                                $('#error-name').text(response.error
                                    .name);
                                $('#error-email').text(response.error
                                    .email);
                            } else {

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
                                $('#carrer_id').val('');
                                $('#tgl_mulai').val('');
                                $('#tgl_selesai').val('');
                            }
                        }
                    });
                });
            });
            $('#head-cb').on('click', function() {
                if ($('#head-cb').prop('checked') === true) {
                    $('#myTable tbody tr').css('background-color', '#f5f5f5');
                    $('.child-cb').prop('checked', true);
                    $('#hapus').prop('disabled', false);


                } else {
                    $('#hapus').prop('disabled', true);
                    $('.child-cb').prop('checked', false);
                    $('#myTable tbody tr').css('background-color', '');
                }
            });

            $('#myTable tbody').on('click', '.child-cb', function() {
                var uncheckedCheckboxes = $('#myTable tbody .child-cb:not(:checked)');
                uncheckedCheckboxes.closest('tr').css('background-color', '');
                if ($(this).prop('checked') === false) {
                    $('#head-cb').prop('checked', false);
                }
                $('#myTable tbody .child-cb:checked').closest('tr').css('background-color', '#f5f5f5');
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
                    $('#head-cb').prop('checked', false);
                    $('#hapus').prop('disabled', true);
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
    {{-- // $('#batch').val(response.result.apply.carrer.batch);
    // var selectJob = response.result.apply.job_magang_id;
    // $('#job_magang_id option').each(function() {
    // var optionVal = $(this).val();

    // if (selectJob === parseInt(optionVal)) {
    // $(this).prop('selected', true);
    // } else {
    // $(this).prop('selected', false);
    // }
    // });
    // var selectBatch = response.result.apply.carrer_id;
    // $('#batch option').each(function() {
    // var optionValBatch = $(this).val();

    // if (selectBatch === parseInt(optionValBatch)) {
    // $(this).prop('selected', true)
    // } else {
    // $(this).prop('selected', false);
    // }
    // }); --}}
@endsection
