<div class="border-2 border-slate-100 px-2 py-3 mt-5">
    <span class="underline hover:no-underline block w-full text-right mb-5 cursor-pointer"
        x-on:click='remove({{ $num }})'>remove</span>
    <label for="name">Name Aggota ke-{{ $num }}</label>
    <input type="text" name="name[]" class="input-style" id="name" />
    @foreach ($errors->get('name') as $error)
        {{ $error }}
    @endforeach
    <label for="email">Email Anggota</label>
    <input type="email" name="email[]" class="input-style" id="email" />
    @error('email')
        {{ $message }}
    @enderror
    <label for="job">Job</label>
    <select name="job_magang[]" id="job" class="input-style">
        <option value="">Pilih Job Magang</option>
        @foreach ($lowongan as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>

    @error('job_magang')
        {{ $message }}
    @enderror
</div>
