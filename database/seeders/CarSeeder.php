<?php

namespace Database\Seeders;
use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use updateOrCreate to make seeding idempotent (avoid unique constraint failures)
        Car::updateOrCreate([
            'chassis_number' => '1234567890',
        ], [
            'model' => 'toyota',
            'color' => 'black',
            'found_location' => 'kafori',
            'police_station_id' => 1,
        ]);

        Car::updateOrCreate([
            'chassis_number' => '1234567891',
        ], [
            'model' => 'nisan',
            'color' => 'yellow',
            'found_location' => 'almzad',
            'police_station_id' => 2,
        ]);

    }
}
