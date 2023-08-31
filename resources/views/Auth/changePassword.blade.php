<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ url('changePassword') }}" method="post" style="display: flex;flex-direction:column;">
        @csrf

        <form-group style="display: flex">
            <label for="verif_code">Kode</label>
            <input type="verif_code" name="verif_code">
        </form-group>
        <form-group style="display: flex">
            <label for="email">Email</label>
            <input type="email" name="email">
        </form-group>
        <form-group style="display: flex">
            <label for="password">Password</label>
            <input type="password" name="password">
        </form-group>
        <button type="submit">Change Password</button>
    </form>
</body>

</html>
