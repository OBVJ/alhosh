<?php

namespace Database\Seeders;

use App\Models\PoliceStation;
use Illuminate\Database\Seeder;

class PoliceStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PoliceStation::create([
            'name' => 'المركز الأول',
            'location' => 'وسط المدينة',
        ]);

        PoliceStation::create([
            'name' => 'مركز الشرطة الثاني',
            'location' => 'الضاحية الشمالية',
        ]);

        PoliceStation::create([
            'name' => 'مركز الشرطة الثالث',
            'location' => 'الضاحية الجنوبية',
        ]);
    }
}
