<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Ini adalah Email dan Password anda segera verifikasi dan ganti password anda!</h1>
    <div>
        <h1>Email &nbsp; {{ $user->email }}</h1>
        <h1>password &nbsp; {{ $user->password }}</h1>
    </div>
</body>

</html>
