<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $primaryKey = 'location_id';
    protected $fillable = ['location_name'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'location_id', 'location_id');
    }
}
