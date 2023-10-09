@extends('layouts.dashboard')
@section('content')
    <div class="my-5">
        <div class="mb-3">
            <button type="button" id="restore" class="btn btn-primary" onclick="restore()" disabled>Restore</button>
        </div>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="head-cb"></th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Gender</th>
                    <th>Alamat</th>
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
                ajax: '/trash',
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                    },
                    {
                        data: 'name',
                        name: 'name'
                    }, {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: "password",
                        name: "password"
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('#head-cb').on('click', function() {
                if ($('#head-cb').prop('checked') === true) {
                    $('.child-cb').prop('checked', true);
                    $('#restore').prop('disabled', false);


                } else {
                    $('#restore').prop('disabled', true);
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
                $('#restore').prop('disabled', !active_checkbox);
            });
            $('body').on('click', '.restore', function(e) {
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
                    confirmButtonText: 'Yes, restore it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'restore/' + id,
                            method: 'PUT',
                            success: function(response) {
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

                            icon: 'error',
                            title: 'Cancelled'
                        });
                    }
                })
            });
        });

        function restore() {
            var checkbox_checked = $('#myTable tbody .child-cb:checked');
            let all_checked = [];
            $.each(checkbox_checked, function(index, value) {
                all_checked.push(value.value);
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
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    for (var i = 0; i < all_checked.length; i++) {
                        $.ajax({
                            method: 'PUT',
                            url: "restore/" + all_checked[i],
                        })
                    }
                    $('#restore').prop('disabled', true);
                    $('#head-cb').prop('checked', false);
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
