<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\BarcodeScan;
use Ramsey\Uuid\Uuid;

class TeacherControlller extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();

        return view('teachers.index', [
            'teachers' => $teachers
        ]);
    }
    public function create()
    {
        return view('teachers.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'nip' => 'required|integer|unique:teachers,nip',
            'name' => 'required',
        ]);

        // Membuat barcode secara acak
        $barcode = Uuid::uuid4()->toString();

        $teacher = Teacher::create([
            'nip' => $request->input('nip'),
            'name' => $request->input('name'),
            'barcode' => $barcode,
        ]);

        // Mencatat pemindaian barcode
        BarcodeScan::create([
            'barcode' => $barcode,
            'scan_timestamp' => now(),
        ]);

        return redirect()->route('teachers.index')
            ->with('success_message', 'Berhasil menambah user baru');
    }

    public function show(string $id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return redirect()->route('teachers.index')
                ->with('error_message', 'Guru tidak ditemukan');
        }

        return view('teachers.show', [
            'teacher' => $teacher
        ]);
    }

    public function edit($id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) return redirect()->route('teachers.index')
            ->with('error_message', 'Guru dengan id' . $id . ' tidak ditemukan');

        return view('teachers.edit', [
            'teacher' => $teacher
        ]);
    }


    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        $request->validate([
            'nip' => 'required|integer|unique:teachers,nip',
            'name' => 'required',
        ]);

        $teacher->nip = $request->input('nip');
        $teacher->name = $request->input('name');
        $teacher->save();

        return redirect()->route('teachers.index')
            ->with('success_message', 'Berhasil mengubah Guru');
    }

    public function destroy(Request $request, $id)
    {
        $teachers = Teacher::find($id);
        $teachers->delete();

        return redirect()->route('teachers.index')
            ->with('success_message', 'Berhasil menghapus Guru');
    }
}
