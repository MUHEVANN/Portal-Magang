@if ($email === 'evan.kusyanto@students.amikom.ac.id')
    ada Pendaftar
@else
    <x-mail::message>
        # Berhasil Daftar.

        Terima kasih sudah Apply lowongan di <strong>Jetorbit</strong>, Silahkan Tunggu Konfirmasi dari kami.

        Salam,<br>
        {{ config('app.name') }}
    </x-mail::message>
@endif
