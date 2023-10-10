{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    Status kelulusan anda adalah {{ $status }}
</body>

</html> --}}

<style>
</style>

<x-mail::message>
    ## Status Pendaftar

    <p>
        Terimakasih sudah tertarik untuk mendaftar magang di <strong>jetorbit</strong>, tetapi sayangnya setelah
        mempertimbangkan dengan cermat.
        Kami menyatakan bahwa status Pendaftaran anda adalah:
    </p>

    <div class="panel-failed">
        <div class="panel-content-failed">
            <p class="text-failed">{{ $status }}</p>
        </div>
    </div>

    <p>
        Kami menghargai minat Anda untuk magang di <strong>jetorbit</strong> Kamu bisa Apply lowongan lagi 60 hari
        kedepan!
    </p>


    Salam Hangat,<br>
    {{ config('app.name') }}
</x-mail::message>
