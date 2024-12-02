<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Shift;


class AttendanceController extends Controller
{
    public function index()
    {
        // Mendapatkan semua data absensi
        $attendances = Attendance::all();

        // Mendapatkan semua data guru
        $teachers = Teacher::all();

        // Inisialisasi array untuk data nama yang belum absen dan sudah absen
        $namaBelumAbsen = [];
        $namaSudahAbsen = [];

        // Looping semua data guru
        foreach ($teachers as $teacher) {
            $absen = $attendances->where('barcode', $teacher->barcode)->first();

            if ($absen) {
                $namaSudahAbsen[] = [
                    'name' => $teacher->name,
                    'attendances' => $absen
                ];
            } else {
                $namaBelumAbsen[] = [
                    'name' => $teacher->name,
                    'barcode' => $teacher->barcode
                ];
            }
        }
        // dd($namaSudahAbsen);
        return view('attendances.index', [
            'namaBelumAbsen' => $namaBelumAbsen,
            'namaSudahAbsen' => $namaSudahAbsen
        ]);
    }
    public function getAttendanceAndDeparture($barcode)
    {

        $timestamp = now();
        $teacher = Teacher::where('barcode', $barcode)->firstOrFail();

        // Cek jika guru sudah melakukan absen sebelumnya pada hari ini
        $existingAttendance = Attendance::where('barcode', $barcode)
            ->whereDate('hour_came', $timestamp->toDateString())
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'Guru sudah melakukan absen hari ini.');
        }

        // Cek waktu sekarang
        $currentTime = $timestamp->format('H:i:s');

        // Cek shift
        $shift = Shift::find(1);

        if (!$shift) {
            return redirect()->back()->with('error', 'Shift tidak ditemukan.');
        }

        $startTime = Carbon::parse($shift->start_time);
        $endTime = Carbon::parse($shift->end_time);

        // Cek absen masuk
        if ($currentTime <= $startTime->addHours(2)) {
            $attendance = new Attendance();
            $attendance->barcode = $barcode;
            $attendance->teacher_id = $teacher->teacher_id;
            $attendance->hour_came = $timestamp;
            $attendance->status = 'Hadir';
            $attendance->save();

            return redirect()->back()->with('success', 'Absen masuk berhasil disimpan.');
        }

        // Cek absen pulang
        if ($currentTime >= $endTime) {
            $attendance = Attendance::where('barcode', $barcode)
                ->where('shift_id', $shift->id)
                ->whereDate('hour_came', $timestamp->toDateString())
                ->first();

            if (!$attendance) {
                return redirect()->back()->with('error', 'Belum melakukan absen masuk.');
            }

            $attendance->home_time = $timestamp;
            $attendance->status = 'Hadir';
            $attendance->overtime_hours = $endTime->diffInHours($timestamp) > 1 ? $endTime->diffInHours($timestamp) - 1 : 0;
            $attendance->save();

            return redirect()->back()->with('success', 'Absen pulang berhasil disimpan.');
        }

        return redirect()->back()->with('error', 'Tidak memenuhi syarat untuk absen masuk atau absen pulang.');
    }

    public function submitSick(Request $request)
    {
        $barcode = $request->input('barcode');
        $timestamp = now();

        $teacher = Teacher::where('barcode', $barcode)->firstOrFail();
        // dd($teacher);

        // Cek jika guru sudah absen sebelumnya
        $attendance = Attendance::where('barcode', $barcode)
            ->whereDate('hour_came', now()->toDateString())
            ->first();

        // if ($attendance) {
        //     return redirect()->back()->with('error', 'Guru sudah melakukan absensi.');
        // }

        // Simpan data absensi sakit
        $attendance = new Attendance();
        $attendance->barcode = $barcode;
        $attendance->hour_came = null;
        $attendance->home_time = null;
        $attendance->teacher_id = $teacher->teacher_id;
        $attendance->status = 'Sakit';
        $attendance->save();

        return redirect()->back()->with('success', 'Absensi sakit berhasil disimpan.');
    }
    public function submitApproval(Request $request)
    {
        $barcode = $request->input('barcode');
        $timestamp = now();

        $teacher = Teacher::where('barcode', $barcode)->firstOrFail();

        // Cek jika guru sudah absen sebelumnya
        $attendance = Attendance::where('barcode', $barcode)
            ->whereDate('hour_came', now()->toDateString())
            ->first();

        // if ($attendance) {
        //     return redirect()->back()->with('error', 'Guru sudah melakukan absensi.');
        // }

        // Simpan data absensi sakit
        $attendance = new Attendance();
        $attendance->barcode = $barcode;
        $attendance->hour_came = null;
        $attendance->home_time = null;
        $attendance->teacher_id = $teacher->teacher_id;
        $attendance->status = 'Izin';
        $attendance->save();

        return redirect()->back()->with('success', 'Absensi sakit berhasil disimpan.');
    }

    public function indexRekap(Request $request)
    {
        $filterBulan = $request->input('filter_bulan', Carbon::now()->month);
        // $filterBulan = 5;

        $teachers = Teacher::all();

        $dataGuru = [];

        foreach ($teachers as $teacher) {
            $totalSakit = Attendance::where('teacher_id', $teacher->teacher_id)
                ->where('status', 'Sakit')
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->whereMonth('created_at', '=', $filterBulan)
                ->count();

            $totalIzin = Attendance::where('teacher_id', $teacher->teacher_id)
                ->where('status', 'Izin')
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->whereMonth('created_at', '=', $filterBulan)
                ->count();

            $totalHadir = Attendance::where('teacher_id', $teacher->teacher_id)
                ->where('status', 'Hadir')
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->whereMonth('created_at', '=', $filterBulan)
                ->count();

            $dataGuru[] = [
                'nama' => $teacher->name,
                'nip' => $teacher->nip,
                'totalSakit' => $totalSakit,
                'totalIzin' => $totalIzin,
                'totalHadir' => $totalHadir,
            ];
        }
        return view('attendances.detail', compact('dataGuru'));
    }
}
