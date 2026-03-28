<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
    public function index()
    {
        $students = DB::table('students')->get();

        return view('admin.dashboard.students.index', [
            'students' => $students
        ]);
    }

    public function create()
    {
        return view('admin.dashboard.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|max:255',
            'userName' => 'required|max:255',
            'userEmail' => 'required|email|unique:students,userEmail',
            'password' => 'required|min:6',
            'kelas' => 'required|max:255',
        ]);

        DB::table('students')->insert([
            'nis' => $request->nis,
            'userName' => $request->userName,
            'userEmail' => $request->userEmail,
            'password' => md5($request->password),
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student berhasil ditambahkan!');
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
            'nis' => 'required|max:255',
            'userName' => 'required|max:255',
            'userEmail' => 'required|email|unique:students,userEmail,' . $id . ',userID',
            'kelas' => 'required|max:255',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'nis' => $request->nis,
            'userName' => $request->userName,
            'userEmail' => $request->userEmail,
            'kelas' => $request->kelas,
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