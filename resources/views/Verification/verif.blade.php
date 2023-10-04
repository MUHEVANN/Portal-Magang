<x-mail::message>
## Kode Verifikasi

Klik Tombol Tautan Berikut ini untuk mem-verifikasi akun anda agar bisa mengaktifkan akun anda.

<x-mail::button url="{{ route('verif', ['verif' => $user]) }}">
    Verifikasi
</x-mail::button>

Salam Hangat,<br>
{{ config('app.name') }}
</x-mail::message>

