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

<x-mail::message>
## Status Pendaftar

<p>
Terimakasih sudah tertarik untuk mendaftar magang di <strong>jetorbit</strong>.
Kami menyatakan bahwa status Pendaftaran anda adalah:
</p>

<div class="panel-success">
<div class="panel-content-success">
<p class="text-success">{{ $status }}</p>
</div>
</div>

<p>
Kami mengharapkan ketersediaan anda di <strong>jetorbit</strong> 
dan bekerja sama selama magang berlangsung!
</p>

Salam Hangat,<br>
{{ config('app.name') }}
</x-mail::message>
