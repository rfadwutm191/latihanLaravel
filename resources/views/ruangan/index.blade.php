<!DOCTYPE html>
<html>
<head>
    <title>Data Ruangan</title>
</head>
<body>
    <h1>Tambah Ruangan</h1>
    <form method="POST" action="/ruangan">
        @csrf
        <input type="text" name="nama_ruangan" placeholder="Nama Ruangan"><br>
        <input type="number" name="kapasitas" placeholder="Kapasitas"><br>
        <button type="submit">Simpan</button>
    </form>

    <h2>List Ruangan</h2>
    <ul>
        @foreach($data as $r)
            <li>{{ $r->nama_ruangan }} - Kapasitas: {{ $r->kapasitas }}</li>
        @endforeach
    </ul>
</body>
</html>
