<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarcodeScan extends Model
{
    use HasFactory;

    protected $primaryKey = 'barcode';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['barcode', 'scan_timestamp'];

    public function attendance()
    {
        return $this->hasOne(Attendance::class, 'barcode', 'barcode');
    }
}
