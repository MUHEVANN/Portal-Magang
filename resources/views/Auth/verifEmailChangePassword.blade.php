@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover-underline">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/">Kembali</a>
    </div>
@endsection
@section('content')
    <div class="mx-auto sm:w-7/12 p-5 rounded-md border-[1px] bg-white shadow-sm border-slate-100" x-data="gates">
        <h1 class="sub-title">Lupa Password</h1>
        <form action="{{ url('verif-email-changePassword') }}" method="post" x-on:submit="forgetPassword">
            @csrf
            <label for="email">Email</label>
            <input type="email" id='email' x-model="verify_email_pass" placeholder="e.g. fulan@email.com"
                name="email" class="input-style">
            {{-- indicator Alert --}}
            <li x-show="verify_email_pass.length > 0" class="flex items-center pb-5">
                <div :class="{
                    'bg-green-200 text-green-700': validateUserEmail(),
                    'bg-red-200 text-red-700': !validateUserEmail(),
                }"
                    class="rounded-full p-1 fill-current">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="validateUserEmail()" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                        <path x-show="!validateUserEmail()" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <span
                    :class="{
                        'text-red-700': !validateUserEmail(),
                        'text-green-700': validateUserEmail(),
                    }"
                    class="font-medium text-sm ml-3"
                    x-text="validateUserEmail() ? 
                'Email sudah valid' : 'Email belum Valid!'"></span>
            </li>
            <span class="block text-sm text-slate-500">Tidak mendapatkan email kode? <a href="#"
                    class="hover-underline text-blue-950 mb-3">Kirim ulang kode.</a> </span>
            {{-- end indicator alert --}}
            <button type="submit" class="btn-style">Kirim
                kode</button>
            <br>
        </form>
        <form action="" method="post">
            @csrf
            <span class="text-red-500 mb-2" x-text="old_pass_invalid"></span>

            <hr class="my-5">
            <h3 class="text-xl text-center mb-3 opacity-80">Ketikan Password Baru</h3>

            <label for="confirm_code">Kode Konfirmasi</label><br>

            <div class="relative mt-2" x-transition>
                <input type="text" id='confirm_code' placeholder="Masukan 16 digit kode verifikasi dari email."
                    name="confirm_code" class=" bg-gray-100 py-2 px-2 w-full" required>
            </div>
            <span class="text-red-500 mb-2" x-text="new_pass_invalid"></span> <br>

            <label for="password_baru">Password</label> <br>
            <div class="relative mt-2" x-transition>
                <input :type="!isVisible1 ? 'password' : 'text'" x-model="new_forget_pass" id='password_baru'
                    name="password_baru" class=" bg-gray-100 py-2 px-2 w-full" placeholder="Password baru kamu" required>
                <img :src="!isVisible1 ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator' x-on:click='toggle1()'
                    class="absolute cursor-pointer w-6 top-2 right-3" alt="">
            </div>


            <span class="text-red-500 mb-2" x-text="new_pass_invalid"></span> <br>


            <label for="repeat_password">Ulangi Password</label> <br>
            <div class="relative mt-2" x-transition>
                <input :type="!isVisible2 ? 'password' : 'text'" x-model="repeat_new_forget_pass" id='repeat_password'
                    name="repeat_password" class=" bg-gray-100 py-2 px-2 w-full" placeholder="Ulangi password baru kamu"
                    required>
                <img :src="!isVisible2 ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator' x-on:click='toggle2()'
                    class="absolute cursor-pointer w-6 top-2 right-3" alt="">
            </div>
            <span class="text-red-500" x-text="repeat_pass_invalid"></span> <br>

            <button type="submit" class="btn-style">Ubah Password</button>
        </form>
    </div>
@endsection
