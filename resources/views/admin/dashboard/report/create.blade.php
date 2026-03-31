@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Laporan</h3>

    <form action="{{ route('admin.report.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="userName" placeholder="Nama" class="form-control mb-2" required>
        <input type="text" name="kelas" placeholder="Kelas" class="form-control mb-2" required>

        <textarea name="keterangan" class="form-control mb-2" placeholder="Keterangan" required></textarea>
        <textarea name="alasan" class="form-control mb-2" placeholder="Alasan" required></textarea>

        <input type="date" name="tanggal" class="form-control mb-2" required>

        <input type="file" name="bukti" class="form-control mb-3">

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection