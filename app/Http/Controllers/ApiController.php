<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function absen(Request $request)
    {
        $barcode = $request->barcode;

        $timestamp = Carbon::now();

        // return $timestamp;
        $teacher = Teacher::where('barcode', $barcode)->first();
        $showTime = $timestamp->format('H:i');
        // Cek waktu sekarang
        $currentTime = $timestamp->format('H:i:s');

        // Cek jika guru tidak ditemukan
        if (!$teacher) {
            return response()->json([
                'status' => 'success',
                'message' => 'ID Barcode tidak ditemukan.',
                'id' => '',
                'name' => '',
                'jam' => ''
            ]);
        }

        // Cek shift
        $shift = Shift::find(1);

        if (!$shift) {
            return response()->json([
                'status' => 'success',
                'message' => 'Shift tidak ditemukan.'
            ]);
        }

        $startTime = Carbon::parse($shift->start_time);
        $endTime = Carbon::parse($shift->end_time);


        $existingAttendance = Attendance::where('barcode', $barcode)
            ->whereDate('hour_came', $timestamp->toDateString())
            ->first();

        if ($existingAttendance) {
            // Guru sudah melakukan absen
            if ($currentTime >= $endTime->subHour() || $currentTime <= $endTime->addHour()) {
                $existingAttendance = Attendance::where('barcode', $barcode)
                    ->whereDate('hour_came', $timestamp->toDateString())
                    ->first();

                if (!$existingAttendance) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Belum melakukan absen masuk.',
                        'id' => $teacher->nip,
                        'name' => $teacher->name,
                        'jam' => $showTime
                    ]);
                }

                $existingAttendance->home_time = $timestamp;
                $existingAttendance->status = 'Hadir';
                $existingAttendance->overtime_hours = $endTime->diffInHours($timestamp) > 1 ? $endTime->diffInHours($timestamp) - 1 : 0;
                $existingAttendance->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Absen pulang.',
                    'id' => $teacher->nip,
                    'name' => $teacher->name,
                    'jam' => $showTime
                ]);
            }
        } else {
            if ($currentTime <= $startTime->addHours(2)) {
                $attendance = new Attendance();
                $attendance->barcode = $barcode;
                $attendance->teacher_id = $teacher->teacher_id;
                $attendance->hour_came = $timestamp;
                $attendance->status = 'Hadir';
                $attendance->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Absen masuk.',
                    'id' => $teacher->nip,
                    'name' => $teacher->name,
                    'jam' => $showTime
                ]);
            }
        }

        // Jika tidak memenuhi syarat untuk absen masuk atau absen pulang
        return response()->json([
            'status' => 'success',
            'message' => 'Tidak memenuhi syarat untuk absen masuk atau absen pulang.',
            'id' => $teacher->nip,
            'name' => $teacher->name,
            'jam' => $showTime
        ]);
    }

    public function testabsen(Request $request)
    {
        $barcode = $request->barcode;

        // $timestamp = Carbon::now();
        $timestamp = Carbon::parse($request->waktuSekarang);
        // 2023-06-15 15:59:00
        // return $timestamp;
        $teacher = Teacher::where('barcode', $barcode)->first();
        $showTime = $timestamp->format('H:i');
        // Cek waktu sekarang
        $currentTime = $timestamp->format('H:i:s');

        // Cek jika guru tidak ditemukan
        if (!$teacher) {
            return response()->json([
                'status' => 'success',
                'message' => 'ID Barcode tidak ditemukan.',
                'id' => '',
                'name' => '',
                'jam' => ''
            ]);
        }

        // Cek shift
        $shift = Shift::find(1);

        if (!$shift) {
            return response()->json([
                'status' => 'success',
                'message' => 'Shift tidak ditemukan.'
            ]);
        }

        $startTime = Carbon::parse($shift->start_time);
        $endTime = Carbon::parse($shift->end_time);
        // $startTime = Carbon::parse('08:00:00');
        // $endTime = Carbon::parse('16:00:00');


        $existingAttendance = Attendance::where('barcode', $barcode)
            ->whereDate('hour_came', $timestamp->toDateString())
            ->first();

        if ($existingAttendance) {
            // Guru sudah melakukan absen
            if ($currentTime >= $endTime->subHour() || $currentTime <= $endTime->addHour()) {
                $existingAttendance = Attendance::where('barcode', $barcode)
                    ->whereDate('hour_came', $timestamp->toDateString())
                    ->first();

                if (!$existingAttendance) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Belum melakukan absen masuk.',
                        'id' => $teacher->nip,
                        'name' => $teacher->name,
                        'jam' => $showTime
                    ]);
                }

                $existingAttendance->home_time = $timestamp;
                $existingAttendance->status = 'Hadir';
                $existingAttendance->overtime_hours = $endTime->diffInHours($timestamp) > 1 ? $endTime->diffInHours($timestamp) - 1 : 0;
                $existingAttendance->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Absen pulang.',
                    'id' => $teacher->nip,
                    'name' => $teacher->name,
                    'jam' => $showTime
                ]);
            }
        } else {
            if ($currentTime <= $startTime->addHours(2)) {
                $attendance = new Attendance();
                $attendance->barcode = $barcode;
                $attendance->teacher_id = $teacher->teacher_id;
                $attendance->hour_came = $timestamp;
                $attendance->status = 'Hadir';
                $attendance->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Absen masuk.',
                    'id' => $teacher->nip,
                    'name' => $teacher->name,
                    'jam' => $showTime
                ]);
            }
        }

        // Jika tidak memenuhi syarat untuk absen masuk atau absen pulang
        return response()->json([
            'status' => 'success',
            'message' => 'Tidak memenuhi syarat untuk absen masuk atau absen pulang.',
            'id' => $teacher->nip,
            'name' => $teacher->name,
            'jam' => $showTime
        ]);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->api_token = Str::random(60);
            $user->save();

            return response()->json([
                'status' => 'success',
                'api_token' => $user->api_token,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->api_token = null;
        $user->save();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
}
