<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();

        return view('shifts.index', [
            'shifts' => $shifts
        ]);
    }
    public function create()
    {
        return view('shifts.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'shift_name' => 'required',
        ]);

        $shift = Shift::create([
            'shift_name' => $request->input('shift_name'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
        ]);


        return redirect()->route('shifts.index')
            ->with('success_message', 'Berhasil menambah user baru');
    }


    public function edit($id)
    {
        $shift = Shift::find($id);
        if (!$shift) return redirect()->route('shifts.index')
            ->with('error_message', 'Jadwal Shift dengan id' . $id . ' tidak ditemukan');

        return view('shifts.edit', [
            'shift' => $shift
        ]);
    }


    public function update(Request $request, $id)
    {
        $shift = Shift::find($id);

        $request->validate([
            'shift_name' => 'required',
        ]);

        $shift->shift_name = $request->input('shift_name');
        $shift->start_time = $request->input('start_time');
        $shift->end_time = $request->input('end_time');
        $shift->save();

        return redirect()->route('shifts.index')
            ->with('success_message', 'Berhasil mengubah Guru');
    }

    public function destroy(Request $request, $id)
    {
        $shift = Shift::find($id);
        $shift->delete();

        return redirect()->route('shifts.index')
            ->with('success_message', 'Berhasil menghapus Guru');
    }
}
