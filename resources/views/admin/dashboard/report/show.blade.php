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

    .badge-status {
        font-size: 14px;
        padding: 6px 12px;
    }
</style>

<body>

    @include('layouts.partials.admin-navbar')

    <div class="page-header">
        <div class="container">
            <h2><i class="bi bi-flag-fill me-2"></i>Report Management</h2>

            <nav>
                <a href="{{ route('admin.dashboard') }}" class="text-white">Dashboard</a> /
                <a href="{{ route('admin.report.index') }}" class="text-white">Report</a> /
                <span>Detail</span>
            </nav>
        </div>
    </div>

    <div class="container mb-5">
        <div class="card shadow-sm">

            <!-- HEADER -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Report</h5>

                {{-- STATUS BADGE --}}
                @php
                $statusColor = match($report->status) {
                'approved' => 'success',
                'rejected' => 'danger',
                default => 'warning'
                };
                @endphp

                <span class="badge bg-{{ $statusColor }} badge-status">
                    {{ ucfirst($report->status) }}
                </span>
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
                            {{ \Carbon\Carbon::parse($report->tanggal)->format('d M Y') }}
                        </p>

                    </div>

                    <!-- GAMBAR -->
                    <div class="col-md-6">
                        <strong>Bukti:</strong><br><br>

                        @if($report->bukti)
                        <a href="{{ route('admin.report.viewBukti', $report->reportID) }}" target="_blank">
                            <img src="{{ asset('storage/' . $report->bukti) }}"
                                class="img-fluid rounded border"
                                style="max-height:300px;">
                        </a>
                        <p class="mt-2 text-muted">Klik gambar untuk memperbesar</p>
                        @else
                        <p class="text-muted">Tidak ada bukti</p>
                        @endif
                    </div>
                </div>

                {{-- UPDATE STATUS --}}
                <hr>

                <form action="{{ route('admin.report.updateStatus', $report->reportID) }}" method="POST">
                    @csrf

                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $report->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Update Status
                            </button>
                        </div>
                    </div>
                </form>

                {{-- ACTION --}}
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.report.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <form action="{{ route('admin.report.destroy', $report->reportID) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger" onclick="return confirm('Yakin hapus laporan ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

</html>