<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    index lowongan admin
    <div>
        @foreach ($lowongan as $item)
            {{ $item->name }}
            <div>
                <form action="{{ url('lowongan/' . $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        Hapus
                    </button>
                </form>
                <button>
                    <a href="{{ url('lowongan/' . $item->id . '/edit') }}">Edit</a>
                </button>
            </div>
        @endforeach
    </div>
</body>

</html>
