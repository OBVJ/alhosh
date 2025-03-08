<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // إضافة عمود police_station_id كرقم (يمكن أن يكون nullable إذا لم يكن إلزاميًا)
            $table->unsignedBigInteger('police_station_id')->nullable()->after('found_location');
        });
    }


    /**
     * Reverse the migrations.
     */
  
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('police_station_id');
        });
    }
};

