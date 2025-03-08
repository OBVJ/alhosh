<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PoliceStation extends Model
{
    use HasFactory;

    protected $fillable = ['name','location'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
