@extends('layouts.dashboard')
@section('content')
    <div class="container card py-5">
        <table class="display nowrap table" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <div class="modal fade" id="tambah-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-id">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name">Email</label>
                                <input type="text" name="email" id="email" class="form-control">
                                <span id="error-email" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="name">Username</label>
                                <input type="text" name="name" id="username" class="form-control">
                                <span id="error-username" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="name">Password</label>
                                <input type="text" name="name" id="password" class="form-control">
                                <span id="error-password" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" class="close"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary submit">Submit</button>
                        </div>
                    </form>
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
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
                }
            })

            var table = $('#myTable').DataTable({
                fixedHeader: true,
                responsive: true,
                processing: true,
                serverside: true,
                responsive: true,
                ajax: '/setting-data',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        name: 'email',
                        data: 'email',
                    },
                    {
                        name: 'username',
                        data: 'username',
                    },
                    {
                        name: 'password',
                        data: 'password',
                    },
                    {
                        name: 'action',
                        data: 'action',
                    }
                ]
            })

            $('body').on('click', '.edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#tambah-modal').modal('show');
                $.ajax({
                    type: 'GET',
                    url: 'setting/' + id,
                    success: function(response) {
                        if (!response.success) {
                            $('#error-email').text(response.error[0])
                        }
                        $('#email').val(response.success.email);
                        $('#username').val(response.success.username);
                        $('#password').val(response.success.password);
                    }
                })
                $('.submit').off('click');
                $('.submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('email', $('#email').val())
                    formData.append('username', $('#username').val())
                    formData.append('password', $('#password').val())
                    $.ajax({
                        url: 'setting/' + id,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if (response.error) {
                                $('#error-username').text(response.error.username);
                                $('#error-email').text(response.error.email);
                                $('#error-password').text(response.error.password);
                            } else {
                                $('#username').val('');
                                $('#email').val('');
                                $('#password').val('');

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
                                })
                                table.ajax.reload();
                            }

                        }
                    })
                });
            });
        });
    </script>
@endsection
