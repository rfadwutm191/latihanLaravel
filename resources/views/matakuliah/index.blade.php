<!DOCTYPE html>
<html>
<head>
    <title>Data Ruangan</title>
</head>
<body>
<h1>Tambah Mata Kuliah</h1>
<form method="POST" action="/matakuliah">
    @csrf
    <input type="text" name="nama_matakuliah" placeholder="Nama Mata Kuliah"><br>
    <textarea name="deskripsi" placeholder="Deskripsi"></textarea><br>
    <button type="submit">Simpan</button>
</form>

<h2>List Mata Kuliah</h2>
<ul>
    @foreach($data as $mk)
        <li>{{ $mk->nama_matakuliah }} - {{ $mk->deskripsi }}</li>
    @endforeach
</ul>
</body>
</html>
