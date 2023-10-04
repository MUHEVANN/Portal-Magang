{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1></h1>
    <div>
        <h1>Email &nbsp; {{ $user->email }}</h1>
        <h1>password &nbsp; {{ $password }}</h1>
    </div>
</body>

</html> --}}


<x-mail::message>
# Akun dan Password
 
Ini adalah Email dan Password anda,
Sekarang Anda dapat melakukan verifikasi dan ganti password!
 
<x-mail::table>
| Email             | Password      |
| -------------     |:-------------:|
| {{ $user->email}} | {{$password}} |

</x-mail::table>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>