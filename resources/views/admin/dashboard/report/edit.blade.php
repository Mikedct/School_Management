@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Laporan</h3>

    <form action="{{ route('admin.report.update', $report->reportID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="userName" value="{{ $report->userName }}" class="form-control mb-2">

        <input type="text" name="kelas" value="{{ $report->kelas }}" class="form-control mb-2">

        <textarea name="keterangan" class="form-control mb-2">{{ $report->keterangan }}</textarea>

        <textarea name="alasan" class="form-control mb-2">{{ $report->alasan }}</textarea>

        <input type="date" name="tanggal"
               value="{{ $report->tanggal }}"
               class="form-control mb-2">

        @if($report->bukti)
            <img src="{{ asset('storage/'.$report->bukti) }}" width="100" class="mb-2">
        @endif

        <input type="file" name="bukti" class="form-control mb-3">

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection