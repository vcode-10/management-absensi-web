<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $primaryKey = 'teacher_id';
    protected $fillable = ['name', 'barcode', 'nip'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'teacher_id', 'teacher_id');
    }
}
