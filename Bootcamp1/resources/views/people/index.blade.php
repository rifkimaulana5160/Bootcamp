@extends('layout')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Daftar Orang</h1>
    <a href="{{ route('people.create') }}" class="btn btn-success mb-3">Tambah Data</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>No Telepon</th>
                <th>Photo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($people as $person)
                <tr>
                    <td>{{ $person->nama }}</td>
                    <td>{{ $person->alamat }}</td>
                    <td>{{ $person->jenis_kelamin }}</td>
                    <td>{{ $person->no_telepon }}</td>
                    <td>
                        @if ($person->photo)
                            <img src="{{ asset('storage/' . $person->photo) }}" width="50" alt="Photo">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('people.edit', $person) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('people.destroy', $person) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
