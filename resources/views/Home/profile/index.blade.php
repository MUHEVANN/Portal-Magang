<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>
    <form>

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
                            <input type="text" name="name" id="name" value="{{ $user->name }}"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="name">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" id="email"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="name">Password</label>
                            <input type="password" name="password" value="{{ $user->password }}" id="password"
                                class="form-control">
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
                            <input type="text" name="alamat" value="{{ $user->alamat }}" id="alamat"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="no_hp">NO Hp</label>
                            <input type="number" name="no_hp" value="{{ $user->no_hp }}" id="no_hp"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="job_magang_id">Job Magang</label>
                            <input type="text"
                                value="{{ $user->job_magang_id === 1 ? 'Tidak Ada Job' : $user->lowongan->name }}">
                        </div>
                        <img src="{{ $user->profile_image === null ? '' : asset('storage/profile/' . $user->profile_image) }}"
                            alt="" class="{{ $user->profile_image === null ? 'd-none' : 'd-flex' }}">
                        <div class="mb-3">
                            <label for="job_magang_id">Profile</label>
                            <input type="file" id="profile_image" name="profile_image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary update">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('body').on('click', '.update', function(e) {
                e.preventDefault();
                var formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('email', $('#email').val());
                formData.append('gender', $('#gender').val());
                formData.append('alamat', $('#alamat').val());
                formData.append('no_hp', $('#no_hp').val());
                formData.append('profile_image', $('#profile_image')[0].files[0]);

                $.ajax({
                    type: "POST",
                    url: "update-profile",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            })
        });
    </script>
</body>

</html>
