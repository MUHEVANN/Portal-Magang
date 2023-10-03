@extends('Home.layouts.main')

@section('jumbotron')
    <div class="flex items-center gap-3 cursor-pointer hover-underline">
        <img src="{{ asset('assets/chevron.svg') }}" class="bg-slate-300 text-center rounded-full p-1 rotate-90"
            alt="">
        <a href="/">Kembali</a>
    </div>
@endsection
@section('content')
    <div class="mx-auto sm:w-7/12 p-5 rounded-md border-[1px] bg-white shadow-sm border-slate-100" x-data="apply">
        <h1 class="sub-title">Kode Ganti Password</h1>
        <form action="{{ url('verif-email-changePassword') }}" method="post">
            @csrf
            <label for="email">Email</label>
            <input type="email" id='email' x-model="email_pass" name="email" class="input-style">
            {{-- indicator Alert --}}
            <li x-show="email_pass.length > 0" class="flex items-center pb-5">
                <div :class="{
                    'bg-green-200 text-green-700': validateEmailChange(),
                    'bg-red-200 text-red-700': !validateEmailChange(),
                }"
                    class="rounded-full p-1 fill-current">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="validateEmailChange()" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                        <path x-show="!validateEmailChange()" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <span
                    :class="{
                        'text-red-700': !validateEmailChange(),
                        'text-green-700': validateEmailChange(),
                    }"
                    class="font-medium text-sm ml-3"
                    x-text="validateEmailChange() ? 
                'Email sudah valid' : 'Email belum Valid!' "></span>
            </li>

            {{-- end indicator alert --}}
            <button type="submit" x-on:click="change_pass()" class="btn-style">Kirim
                kode</button>
        </form>
    </div>
@endsection
