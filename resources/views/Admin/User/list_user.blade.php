@extends('layouts.dashboard')
@section('content')
    <div class="card container">
        <div class="my-5">

            <div class="mb-3">
                <button class="btn btn-danger " id="hapus" type="button" onclick="hapus()" disabled>Hapus</button>
            </div>
            <table class="table table-hover" id="myTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" id="head-cb"></th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No Hp</th>
                        <th>Gender</th>
                        <th>Alamat</th>
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
                            <div id="error-password" class="text-danger"></div>
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
                            <label for="no_hp">No Hp</label>
                            <input type="number" name="no_hp" id="no_hp" class="form-control" max="12">
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
                responsive: true,
                processing: true,
                serverside: true,

                ajax: 'list-user',
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
                        data: "no_hp",
                        name: "no_hp"
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

            $('body').on('click', '.edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // console.log(id);
                $.ajax({
                    url: '/edit-user/' + id,
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

                    }
                });
                $("body").off('click', '.update').on('click', '.update', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: 'edit-user/' + id,
                        method: 'PUT',
                        data: {
                            name: $('#name').val(),
                            email: $('#email').val(),
                            password: $('#password').val(),
                            alamat: $('#alamat').val(),
                            gender: $('#gender').val(),
                            no_hp: $('#no_hp').val(),

                        },
                        success: function(response) {
                            if (response.error) {
                                $('#error-name').text(response.error.name);
                                $('#error-email').text(response.error.email);
                                $('#error-password').text(response.error.password);
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
                            url: 'hapus-user/' + id,
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
                            url: "hapus-user/" + all_checked[i],
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
                    $('#head-cb').prop('checked', false);
                    $('#hapus').prop('disabled', true);
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
