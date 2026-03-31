<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // =========================
    // LIST DATA
    // =========================
    public function index()
    {
        $report = DB::table('report')
            ->orderBy('tanggal', 'desc')
            ->get();

        // Statistik
        $statusPending = DB::table('report')->where('status', 'pending')->count();
        $statusApproved = DB::table('report')->where('status', 'approved')->count();
        $statusRejected = DB::table('report')->where('status', 'rejected')->count();

        return view('admin.dashboard.report.index', compact(
            'report',
            'statusPending',
            'statusApproved',
            'statusRejected'
        ));
    }

    // =========================
    // DETAIL
    // =========================
    public function show($id)
    {
        $report = DB::table('report')
            ->where('reportID', $id)
            ->first();

        if (!$report) {
            return redirect()->route('admin.report.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        return view('admin.dashboard.report.show', compact('report'));
    }

    // =========================
    // UPDATE STATUS (APPROVE / REJECT)
    // =========================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $report = DB::table('report')->where('reportID', $id)->first();

        if (!$report) {
            return redirect()->route('admin.report.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        DB::table('report')
            ->where('reportID', $id)
            ->update([
                'status' => $request->status
            ]);

        return redirect()->route('admin.report.show', $id)
            ->with('success', 'Status berhasil diperbarui');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $report = DB::table('report')->where('reportID', $id)->first();

        if (!$report) {
            abort(404);
        }

        // hapus file bukti jika ada
        if ($report->bukti && Storage::disk('public')->exists($report->bukti)) {
            Storage::disk('public')->delete($report->bukti);
        }

        DB::table('report')->where('reportID', $id)->delete();

        return redirect()->route('admin.report.index')
            ->with('success', 'Laporan berhasil dihapus');
    }

    // =========================
    // VIEW BUKTI (IMAGE ONLY)
    // =========================
    public function viewBukti($id)
    {
        $report = DB::table('report')->where('reportID', $id)->first();

        if (!$report || !$report->bukti) {
            return back()->with('error', 'Bukti tidak ditemukan');
        }

        $path = $report->bukti;

        if (!Storage::disk('public')->exists($path)) {
            return back()->with('error', 'File tidak tersedia');
        }

        // validasi file gambar
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return back()->with('error', 'File bukan gambar');
        }

        return response()->file(storage_path('app/public/' . $path));
    }
}