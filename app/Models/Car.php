<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'chassis_number',
        'model',
        'color',
        'found_location',
        'police_station_id',
    ];

    public function policeStation()
    {
        return $this->belongsTo(PoliceStation::class, 'police_station_id');
    }
}

