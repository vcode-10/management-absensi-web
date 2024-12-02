<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'attendance_id';
    protected $fillable = ['timestamp', 'barcode', 'latitude', 'longitude'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }


    public function barcodeScan()
    {
        return $this->belongsTo(BarcodeScan::class, 'barcode', 'barcode');
    }
}
