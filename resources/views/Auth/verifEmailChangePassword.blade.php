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
        <form action="{{ url('verif-email-changePassword') }}" x-init="initBtnCode" method="post"
            x-on:submit="forgetPassword">
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
            {{-- end indicator alert --}}
            <button type="submit" class="btn-style" id="btn-code" x-text="!waitFor ? 'Kirim Kode': count + ' detik'"
                x-bind:disabled="waitFor"></button>
            <br>
        </form>

        <form action="{{ url('changePassword') }}" x-on:submit="changeForgetPassword" method="post">
            @csrf
            <hr class="my-5">
            <h3 class="text-xl text-center mb-3 opacity-80">Ketikan <em>Password</em> Baru</h3>

            <label for="confirm_code">Kode Konfirmasi</label><br>

            <div class="relative mt-2" x-transition>
                <input type="text" id='confirm_code' x-model="confirm_code"
                    placeholder="Masukan 16 digit kode verifikasi dari email." name="verif_code"
                    class=" bg-gray-100 py-2 px-2 mb-2 w-full">
                <span class="text-red-500" x-text="confirm_code_invalid"></span>
            </div>
            <br>
            <label for="password">Password</label> <br>
            <div class="relative mt-2 mb-3" x-transition>
                <input :type="!isVisible1 ? 'password' : 'text'" x-model="new_forget_pass" id='password' name="password"
                    class=" bg-gray-100 py-2 px-2 w-full" placeholder="Password baru kamu">
                <img :src="!isVisible1 ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator' x-on:click='toggle1()'
                    class="absolute cursor-pointer w-6 top-2 right-3" alt="eye-pass">
            </div>

            <label for="repeat_password">Ulangi Password</label> <br>
            <div class="relative my-2" x-transition>
                <input :type="!isVisible2 ? 'password' : 'text'" x-model="repeat_new_forget_pass" id='repeat_password'
                    name="repeat_password" class=" bg-gray-100 py-2 px-2 w-full" placeholder="Ulangi password baru kamu">
                <img :src="!isVisible2 ? 'assets/close-eye.svg' : 'assets/eye.svg'" id='indicator' x-on:click='toggle2()'
                    class="absolute cursor-pointer w-6 top-2 right-3" alt="eye-pass-repeated">
            </div>
            <span class="text-red-500" x-text="new_forget_password_invalid"></span> <br>

            <button type="submit" class="btn-style">Ubah <em>Password</em></button>
        </form>
    </div>
@endsection
