<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    dashboard admin
    <div>
        @foreach ($applyBelumKonfirmasi as $item)
            <h1>
                nama : {{ $item->user->name }}
            </h1>
            <h1>
                apply lowongan : {{ $item->lowongan->name }}
            </h1>
            <h1>
                status Konfirmasi : {{ $item->konfirmasi }}
            </h1>
        @endforeach
    </div>
</body>

</html>
