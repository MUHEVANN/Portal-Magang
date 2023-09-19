@extends('layouts.dashboard')
@section('content')
    <div class="my-5">
        <div class="mb-3 d-flex justify-content-between">
            <div class="mb-3">
                <button class="btn btn-outline-primary" disabled id="btn-konfirmasi" onclick="konfirmasi()">Konfirmasi</button>
                <button class="btn btn-outline-danger" disabled id="btn-reject" onclick="reject()">Reject</button>
            </div>
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
                    <th><input type="checkbox" name="" id="head-cb" /></th>
                    {{-- <th>No</th> --}}
                    <th>Nama</th>
                    <th>cv</th>
                    <th>Job Magang</th>
                    <th>Tipe Magang</th>
                    <th>Status</th>
                    <th>Jabatan</th>
                    <th>Kelompok id</th>
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
                columnDefs: [{
                    visible: false,
                    targets: 7
                }],
                processing: true,
                serverside: true,
                ajax: '/apply-user',
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(7, {
                            page: 'current'
                        })
                        .data()
                        .each(function(group, i) {
                            if (last !== group) {
                                $(rows)
                                    .eq(i)
                                    .before(
                                        '<tr class="group" style="background:#f9f9f9;"><td colspan="8">' +
                                        group +
                                        '</td></tr>'
                                    );

                                last = group;
                            }
                        });
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                    },
                    {
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
                        data: 'kelompok.name',
                        name: 'kelompok.name',
                        render: function(data) {
                            return (data !== null) ? 'kelompok ' + data : 'mandiri';
                        }
                    }, {
                        data: 'action',
                        name: 'action',
                    }
                ],
                order: [
                    [7, 'asc']
                ],
            });

            $('#head-cb').on('click', function() {
                if ($('#head-cb').prop('checked') === true) {
                    $('.child-cb').prop('checked', true);
                    $('#btn-konfirmasi').prop('disabled', false);
                    $('#btn-reject').prop('disabled', false);

                } else {
                    $('#btn-konfirmasi').prop('disabled', true);
                    $('#btn-reject').prop('disabled', true);
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
                $('#btn-konfirmasi').prop('disabled', !active_checkbox);
                $('#btn-reject').prop('disabled', !active_checkbox);

            });

            $('#select-tipe').on('change', function() {
                var tipe = $(this).val();
                table.column(4).search(tipe).draw()
            });
        });

        function konfirmasi() {
            let checkbox_click = $('#myTable tbody .child-cb:checked')
            let all_id = []
            $.each(checkbox_click, function(index, elmn) {
                all_id.push(elmn.value);
            });
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
                confirmButtonText: 'Yes, konfirm it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    for (let i = 0; i < all_id.length; i++) {
                        console.log(all_id[i]);

                        var request = $.ajax({
                            type: "GET",
                            url: "{{ url('apply-status-konfirm') }}" + '/' + all_id[i],
                        });
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

        function reject() {
            let checkbox_click = $('#myTable tbody .child-cb:checked')
            let all_id = []
            $.each(checkbox_click, function(index, elmn) {
                all_id.push(elmn.value);
            });
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
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    for (let i = 0; i < all_id.length; i++) {
                        console.log(all_id[i]);

                        $.ajax({
                            type: "GET",
                            url: "{{ url('apply-status-reject') }}" + '/' + all_id[i],
                            success: function(response) {
                                response.success ? console.log(response.success) : console
                                    .log(response
                                        .gagal);
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                console.error("Error: " + errorThrown);
                            }
                        });
                    }
                    // window.location.href = "{{ url('pendaftar') }}";
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
                        title: 'berhasil reject'
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
