<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @if ($errors->has('sudah-Apply'))
        <div class="alert alert-danger">
            {{ $errors->first('sudah-Apply') }}
        </div>
    @endif

    @if ($errors->has('sudah-lulus'))
        <div class="alert alert-danger">
            {{ $errors->first('sudah-lulus') }}
        </div>
    @endif
    <form action="{{ url('apply-form') }}" id="container" method="post" style="display: flex;flex-direction:column;"
        enctype="multipart/form-data">
        @csrf
        <form-group style="display: flex">
            <label for="name">Name Aggota</label>
            <input type="text" name="name[]" />
        </form-group>

        @foreach ($errors->get('name') as $error)
            {{ $error }}
        @endforeach
        <form-group style="display: flex">
            <label for="email">Email Anggota</label>
            <input type="email" name="email[]" />
        </form-group>
        @error('email')
            {{ $message }}
        @enderror
        <form-group style="display: flex">
            <label for="job">Job</label>
            <select name="job_magang[]" id="">
                <option value="">Pilih Job Magang</option>
                @foreach ($lowongan as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </form-group>

        @error('job_magang')
            {{ $message }}
        @enderror
        <div id="field-container">

        </div>
        <button id="tambah-anggota">Tambah Anggota</button>

        <form-group style="display: flex">
            <label for="cv">CV</label>
            <input type="file" name="cv" />
        </form-group>

        @error('cv')
            {{ $message }}
        @enderror
        <button type="submit">Submit</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#tambah-anggota').click(function(e) {
                e.preventDefault();
                var inputHtml = `
                    <div id='form-group'>
                    
                    <div style="display: flex">
                        <label for="name">Name Aggota</label>
                        <input type="text" name="name[]" />
                    </div>
                    <div style="display: flex">
                        <label for="email">Email Anggota</label>
                        <input type="email" name="email[]" />
                    </div>
                    <div style="display: flex">
                        <label for="job">Job</label>
                        <select name="job_magang[]">
                            <option value="">Pilih Job Magang</option>
                            @foreach ($lowongan as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="hapus-anggota" type='button'>Hapus</button>
                </div>
                `;

                $('#field-container').append(inputHtml);
            });
            $('#form-group').on('click', '.hapus-anggota', function(e) {
                e.preventDefault();
                $(this).closest('.form-group').remove();
            });

        });
    </script>
</body>

</html>
