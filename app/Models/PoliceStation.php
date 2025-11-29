<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoliceStation extends Model
{
    use HasFactory;

    // تحديد الأعمدة التي يمكن تعبئتها بشكل جماعي
    protected $fillable = ['name', 'location'];

    // تعريف العلاقة مع السيارات (الـ Car)
    public function cars()
    {
        return $this->hasMany(Car::class);  // علاقة "يملك العديد" (One to Many)
    }
}

