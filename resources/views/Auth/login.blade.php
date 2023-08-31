<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ url('login') }}" method="post" style="display: flex;flex-direction:column;">
        @csrf
        <form-group style="display: flex">
            <label for="email">Email</label>
            <input type="email" name="email">
        </form-group>
        <form-group style="display: flex">
            <label for="password">Name</label>
            <input type="password" name="password">
        </form-group>
        <button type="submit">Login</button>
    </form>
</body>

</html>
