<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        padding: 30px 0;
        margin-bottom: 30px;
        color: white;
    }

    .card {
        border-radius: 10px;
    }
</style>

<body>

@include('layouts.partials.admin-navbar')

<div class="page-header">
    <div class="container">
        <h2><i class="bi bi-flag-fill me-2"></i>Report Management</h2>

        <nav>
            <a href="{{ route('admin.dashboard') }}" class="text-white">Dashboard</a> /
            <a href="{{ route('admin.reports.index') }}" class="text-white">Report</a> /
            <span>Detail</span>
        </nav>
    </div>
</div>

<div class="container mb-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Report</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <!-- DATA -->
                <div class="col-md-6">

                    <p><strong>Nama:</strong><br>
                        {{ $report->userName }}
                    </p>

                    <p><strong>Kelas:</strong><br>
                        {{ $report->kelas }}
                    </p>

                    <p><strong>Keterangan:</strong><br>
                        {{ $report->keterangan }}
                    </p>

                    <p><strong>Alasan:</strong><br>
                        {{ $report->alasan }}
                    </p>

                    <p><strong>Tanggal:</strong><br>
                        {{ $report->tanggal }}
                    </p>

                </div>

                <!-- GAMBAR -->
                <div class="col-md-6">
                    <strong>Bukti:</strong><br><br>

                    @if($report->bukti)
                        <img src="{{ asset('storage/' . $report->bukti) }}"
                             class="img-fluid rounded border"
                             style="max-height:300px;">
                    @else
                        <p class="text-muted">Tidak ada bukti</p>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>