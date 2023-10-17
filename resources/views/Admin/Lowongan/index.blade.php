@extends('layouts.dashboard')
@section('content')
    <div class="card container">
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
                <button type="button" class="btn btn-outline-primary" id="tambah">
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
                        <th>Deadline</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
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
                                <label for="name">Nama Lowongan</label>
                                <input type="text" name="name" id="name" class="form-control">
                                <span id="error-name" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="desc">Deskripsi</label>
                                <trix-editor class="trix-editor" id="desc"></trix-editor>
                                <span id="error-desc" class="text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label for="benefit">Benefit</label>
                                <trix-editor id="benefit"></trix-editor>
                                <span id="error-benefit" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="kualifikasi">Kualifikasi</label>
                                <trix-editor id="kualifikasi"></trix-editor>
                                <span id="error-kualifikasi" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="deadline">Deadline</label>
                                <input type="date" id="deadline" class="form-control">
                                <span id="error-deadline" class="text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label for="gambar">Gambar</label>
                                <input type="file" name="gambar" id="gambar" class="form-control"
                                    accept=".png,.jpg,.jpeg,.svg">
                                <span id="error-gambar" class="text-danger"></span>
                            </div>

                            <div class="col-12">
                                <img src="" id="image-preview" alt="" class="col-12">
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
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#myTable').DataTable({
                processing: true,
                serverside: true,
                // scrollX: true,
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
                        data: 'description',
                        name: 'description',
                        render: function(data) {
                            var words = data.split(" ");
                            var cutWords = words.slice(0, 3).join(" ");
                            if (words.length > 3) {
                                cutWords += " ...";
                            }
                            return cutWords;
                        }
                    },
                    {
                        data: 'benefit',
                        name: 'benefit',
                        render: function(data) {
                            var words = data.split(" ");
                            var cutWords = words.slice(0, 3).join(" ");
                            if (words.length > 3) {
                                cutWords += " ...";
                            }
                            return cutWords;
                        }
                    },
                    {
                        data: 'kualifikasi',
                        name: 'kualifikasi',
                        render: function(data) {
                            var words = data.split(" ");
                            var cutWords = words.slice(0, 3).join(" ");
                            if (words.length > 3) {
                                cutWords += " ...";
                            }
                            return cutWords;
                        }
                    },
                    {
                        data: 'deadline',
                        name: 'deadline',
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
                ],

            });

            $('#select-batch').on('change', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });
            $('#gambar').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
            $('body').on('click', '#tambah', function(e) {
                e.preventDefault();

                $('#tambah-modal').modal('show');
                $('.submit').off('click');
                $('.submit').click(function(e) {
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('name', $('#name').val());
                    formData.append('desc', $('#desc').val());
                    formData.append('benefit', $('#benefit').val());
                    formData.append('kualifikasi', $('#kualifikasi').val());
                    formData.append('deadline', $('#deadline').val());
                    formData.append('gambar', $('#gambar')[0].files[0]);
                    $.ajax({
                        type: "POST",
                        url: "lowongan",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.error) {
                                $('#error-benefit').text(response.error.benefit);
                                $('#error-name').text(response.error.name);
                                $('#error-desc').text(response.error.desc);
                                $('#error-kualifikasi').text(response.error
                                    .kualifikasi);
                                $('#error-gambar').text(response.error.gambar);
                                $('#error-deadline').text(response.error.deadline);
                            } else {
                                $('#name').val('');
                                $('#deadline').val('');
                                $('#desc').val('');
                                $('#benefit').val('');
                                $('#kualifikasi').val('');
                                $('#gambar').val('');
                                $('#image-preview').attr('src', '');
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
                        var desc = document.querySelector('#desc');
                        desc.editor.loadHTML(response.desc);
                        var benefit = document.querySelector('#benefit');
                        benefit.editor.loadHTML(response.benefit);
                        var kualifikasi = document.querySelector('#kualifikasi');
                        kualifikasi.editor.loadHTML(response.kualifikasi);

                        $('#name').val(response.name);
                        $('#desc').val(response.desc);
                        $('#kualifikasi').val(response.kualifikasi);
                        $('#benefit').val(response.benefit);
                        $('#deadline').val(response.deadline);
                        $('#image-preview').attr('src', '/storage/lowongan/' + response.gambar);
                    },
                });
                $('.submit').off('click');
                $('.submit').click(function(e) {
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('name', $('#name').val());
                    formData.append('deadline', $('#deadline').val());
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
                            if (response[0] === 'error') {
                                $('#error-benefit').text(response[1].benefit);
                                $('#error-name').text(response[1].name);
                                $('#error-desc').text(response[1].desc);
                                $('#error-kualifikasi').text(response[1]
                                    .kualifikasi);
                                $('#error-gambar').text(response[1].gambar);
                                $('#error-deadline').text(response[1].deadline);
                            } else {
                                $('#name').val('');
                                $('#desc').val('');
                                $('#benefit').val('');
                                $('#kualifikasi').val('');
                                $('#gambar').val('');
                                $('#deadline').val('');
                                $('#image-preview').attr('src', '');
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
                    });
                });
            });
            $('.close').click(function() {
                $('#name').val('');
                $('#desc').val('');
                $('#benefit').val('');
                $('#kualifikasi').val('');
                $('#deadline').val('');
                $('#image-preview').attr('src', '');
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
                    title: 'Yakin ingin menghapus lowongan?',
                    text: "Semua Apply yang berkaitan juga akan terhapus!",
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
                                const Toast = Swal.mixin({
                                    width: 400,
                                    padding: 15,
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
                                    title: 'Signed in successfully'
                                })
                                table.ajax.reload();
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
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

                            icon: 'error',
                            title: 'Tidak jadi menghapus'
                        })
                    }
                })
            });

        });
    </script>
@endsection
