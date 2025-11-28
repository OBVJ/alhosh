<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    // تحديد الأعمدة التي يمكن تعبئتها بشكل جماعي
    protected $fillable = [
        'chassis_number', 'model', 'color', 'found_location', 'police_station_id'
    ];

    // تعريف العلاقة مع مركز الشرطة (الـ PoliceStation)
    public function policeStation()
    {
        return $this->belongsTo(PoliceStation::class);  // علاقة "ينتمي إلى" (One to Many)
    }
}