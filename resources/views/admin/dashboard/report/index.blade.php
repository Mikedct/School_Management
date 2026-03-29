<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Report Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>

    @include('layouts.partials.admin-navbar')

    <div class="page-wrapper">

        <!-- HEADER -->
        <div class="page-header">
            <div class="container">
                <h2 class="text-white">
                    <i class="bi bi-flag-fill me-2"></i>Report Management
                </h2>

                <a href="{{ route('admin.dashboard') }}" class="text-white">Dashboard</a> /
                <span class="text-white">Report</span>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="container mb-4">
            <div class="row g-3">

                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <h5>Pending</h5>
                        <h3>{{ $statusPending }}</h3>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <h5>Approved</h5>
                        <h3>{{ $statusApproved }}</h3>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <h5>Rejected</h5>
                        <h3>{{ $statusRejected }}</h3>
                    </div>
                </div>

            </div>
        </div>

        <div class="container mb-5">

            {{-- ALERT --}}
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>Daftar Laporan</h5>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Keterangan</th>
                                <th>Alasan</th>
                                <th>Bukti</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($report as $index => $report)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $report->userName }}</td>
                                <td>{{ $report->kelas }}</td>
                                <td>{{ $report->keterangan }}</td>
                                <td>{{ $report->alasan }}</td>

                                <td>
                                    @if($report->bukti)
                                    <a href="{{ route('admin.report.viewBukti', $report->reportID) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $report->bukti) }}" width="60">
                                    </a>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($report->tanggal)->format('d M Y') }}
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @php
                                    $color = match($report->status) {
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    default => 'warning'
                                    };
                                    @endphp

                                    <span class="badge bg-{{ $color }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <a href="{{ route('admin.report.show', $report->reportID) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <form action="{{ route('admin.report.destroy', $report->reportID) }}"
                                        method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    Tidak ada laporan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>