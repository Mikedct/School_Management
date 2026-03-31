<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
    public function index()
    {
        $students = DB::table('students')->get();

        $totalStudents = DB::table('students')->count();
        $activeStudents = DB::table('students')->where('status', 'Active')->count();
        $inactiveStudents = DB::table('students')->where('status', 'Inactive')->count();

        return view('admin.dashboard.students.index', compact(
            'students',
            'totalStudents',
            'activeStudents',
            'inactiveStudents'
        ));
    }

    public function create()
    {
        return view('admin.dashboard.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'userName' => 'required',
            'userEmail' => 'required|email|unique:students,userEmail',
            'password' => 'required|min:6',
            'kelas' => 'required',
            'status' => 'required',
            'phone' => 'nullable',
        ]);

        DB::table('students')->insert([
            'nis' => $request->nis,
            'userName' => $request->userName,
            'userEmail' => $request->userEmail,
            'password' => md5($request->password),
            'kelas' => $request->kelas,
            'status' => $request->status,
            'phone' => $request->phone,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student berhasil ditambahkan!');
    }

    public function show($id)
    {
        $student = DB::table('students')->where('userID', $id)->first();

        if (!$student) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Student tidak ditemukan');
        }

        return view('admin.dashboard.students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = DB::table('students')->where('userID', $id)->first();

        if (!$student) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Student tidak ditemukan');
        }

        return view('admin.dashboard.students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required',
            'userName' => 'required',
            'userEmail' => 'required|email|unique:students,userEmail,' . $id . ',userID',
            'kelas' => 'required',
            'password' => 'nullable|min:6',
            'status' => 'required',
            'phone' => 'nullable',
        ]);

        $data = [
            'nis' => $request->nis,
            'userName' => $request->userName,
            'userEmail' => $request->userEmail,
            'kelas' => $request->kelas,
            'status' => $request->status,
            'phone' => $request->phone,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = md5($request->password);
        }

        DB::table('students')
            ->where('userID', $id)
            ->update($data);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student berhasil diupdate!');
    }

    public function destroy($id)
    {
        DB::table('students')->where('userID', $id)->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student berhasil dihapus!');
    }
}