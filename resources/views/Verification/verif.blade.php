<x-mail::message>
## Kode Verifikasi

Klik Tombol Tautan Berikut ini untuk mem-verifikasi akun anda agar bisa mengaktifkan akun anda.

<a href="{{ route('verif', $user) }}" class="button-blue button text-center block">
Verifikasi
</a>

Salam Hangat,<br>
{{ config('app.name') }}
</x-mail::message>

