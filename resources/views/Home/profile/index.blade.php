@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover:underline">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/">Kembali</a>
    </div>
@endsection
@section('content')
    <div class="mx-auto w-7/12 p-5 rounded-md border-2 border-slate-100">
        <h1 class="text-slate-800 text-2xl font-extrabold mb-5">Profilku</h1>
        <form>
            <img src="" alt="user profile" class="rounded-full object-cover w-40 h-40 mb-3" id="image-preview">
            <div class="mb-3">
                <label for="job_magang_id">Profile</label>
                <input type="file" id="profile_image" name="profile_image" class="input-style"
                    accept=".jpg,.png,.svg,.jpeg">
            </div>

            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="input-style">
            </div>
            <div class="mb-3">
                <label for="name">Email</label>
                <input type="email" name="email" id="email" class="input-style">
            </div>
            {{-- <div class="mb-3">
                <label for="name">Password</label>
                <input type="password" name="password" id="password" class="input-style" disabled>
            </div> --}}
            <div class="mb-3">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="input-style">
                    <option value="">pilih gender</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="input-style">
            </div>
            <div class="mb-3">
                <label for="no_hp">Nomor WA</label>
                <input type="number" name="no_hp" id="no_hp" class="input-style">
            </div>
            <div class="mb-3">
                <label for="job_magang_id">Job Magang</label>
                <input type="text" name="job_magang_id" id="job_magang_id" class="input-style">
            </div>

            <div class="modal-footer">
                <button type="button"
                    class="py-2 bg-gray-300 px-5 rounded hover:opacity-80 mt-5 my-3 ml-auto text-slate-950 update">Update</button>
            </div>
        </form>
    @section('script')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: "profile-user",
                    success: function(response) {
                        console.log(response);
                        response.profile_image === null ? $('#image-preview').attr('src',
                            'images/profile.jpg') : $('#image-preview').attr('src', "storage/profile/" +
                            response.profile_image);
                        $('#name').val(response.name);
                        $('#email').val(response.email);
                        $('#password').val(response.password);
                        $('#gender').val(response.gender);
                        $('#alamat').val(response.alamat);
                        $('#no_hp').val(response.no_hp);
                        $('#job_magang_id').val(response.job_magang_id);
                    }
                });
                $('#profile_image').change(function() {
                    var input = this;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#image-preview').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
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
                            console.log(response);
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
    @endsection
</div>
@endsection
