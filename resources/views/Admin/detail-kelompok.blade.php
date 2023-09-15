@extends('layouts.dashboard')
@section('content')
    <div class="my-5">
        <div class="mb-3">
            <button class="btn btn-outline-primary" disabled id="btn-konfirmasi" onclick="konfirmasi()">Konfirmasi</button>
            <button class="btn btn-outline-danger" disabled id="btn-reject" onclick="reject()">Reject</button>
        </div>
        <table class="table table-stiped" id="myTable">
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="head-cb" /></th>
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
            let on_click = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = '{{ $kelompok->id }}';
            var table = $('#myTable').DataTable({
                order: [
                    [1, 'asc']
                ],
                processing: true,
                serverside: true,
                ajax: '/apply-user-get-detail/' + id,
                columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                }, {
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

                        $.ajax({
                            type: "GET",
                            url: "{{ url('apply-status-konfirm') }}" + '/' + all_id[i],
                            success: function(response) {
                                response.success ? console.log(response.success) : console.log(response
                                    .gagal);
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                console.error("Error: " + errorThrown);
                            }
                        });
                    }
                    $('#myTable').DataTable().ajax.reload();

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
                                response.success ? console.log(response.success) : console.log(response
                                    .gagal);
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                console.error("Error: " + errorThrown);
                            }
                        });
                    }
                    // window.location.href = "{{ url('pendaftar') }}";
                    $('#myTable').DataTable().ajax.reload();
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
@endsection
