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
            // Add column only if it doesn't already exist (guards against duplicate migrations)
            if (!Schema::hasColumn('cars', 'police_station_id')) {
                $table->unsignedBigInteger('police_station_id')->nullable()->after('found_location');
                // Only add FK if the referenced table exists (prevents ordering issues during fresh migrations/tests)
                if (Schema::hasTable('police_stations')) {
                    $table->foreign('police_station_id')->references('id')->on('police_stations')->onDelete('set null');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Remove foreign key and column only if the column exists
            if (Schema::hasColumn('cars', 'police_station_id')) {
                // try to drop foreign key if it exists
                if (Schema::hasTable('police_stations')) {
                    try {
                        $table->dropForeign(['police_station_id']);
                    } catch (\Exception $e) {
                        // ignore if foreign key does not exist
                    }
                }
                $table->dropColumn('police_station_id');
            }
        });
    }
};

