@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover:underline w-fit">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/">Kembali</a>
    </div>
@endsection


@section('content')
    <div class="mx-auto sm:w-7/12 p-5 rounded-md border-[1px] bg-white shadow-sm border-slate-100">
        <h1 class="sub-title">Profilku</h1>
        <section x-data='profile' x-init="initWaitFor30Seconds">
            <img src="" alt="user profile" class="rounded-full object-cover w-40 h-40 mb-3" id="image-preview">
            <div class="mb-3">
                <label for="job_magang_id">Profile</label>
                <input type="file" id="profile_image" name="profile_image" class="input-style"
                    accept=".jpg,.png,.svg,.jpeg">
            </div>

            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="input-style">
                <p class="error-name"></p>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <div class="flex items-center">
                    <input type="email" name="email" id="email" style="margin-right: 0px"
                        class=" input-style w-3/5">
                    @if (Auth::check() && Auth::user()->is_active == 0)
                        <form class="w-2/5 ml-3">
                            <button type="submit" class="btn-style w-full" x-on:click="waitFor30Seconds"
                                x-text="!waitFor ? 'Verifikasi': count + ' detik'" x-bind:disabled="waitFor"></button>
                        </form>
                    @endif
                </div>
            </div>
            <a href="/changePassword" class="btn-style my-5 block text-center w-full">Ubah Password</a>
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


            <div class="modal-footer">
                <button type="button"
                    class="py-2 bg-gray-300 px-5 rounded w-full sm:w-fit block hover:opacity-80 mt-5 my-3 mr-auto text-slate-950 update">Perbarui</button>
            </div>
        </section>
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
            $.ajax({
                type: "GET",
                url: "profile-user",
                success: function(response) {
                    response.profile_image === null ? $('#image-preview').attr('src',
                        'images/profile.jpg') : $('#image-preview').attr('src', "storage/profile/" +
                        response.profile_image);
                    $('#name').val(response.name);
                    $('#email').val(response.email);
                    $('#password').val(response.password);
                    $('#gender').val(response.gender);
                    $('#alamat').val(response.alamat);
                    $('#no_hp').val(response.no_hp);

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
                        if (!response.success) {
                            $('.error-name').text(response.error.name);
                        }

                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener("mouseenter", Swal
                                    .stopTimer);
                                toast.addEventListener("mouseleave", Swal
                                    .resumeTimer);
                            },
                        });

                        Toast.fire({
                            icon: 'success',
                            title: 'Pembaruan berhasil disimpan',
                        });
                    }
                });
            })
        });
    </script>
@endsection
