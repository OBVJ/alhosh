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
        Schema::table('search_notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('search_notifications', 'search_date')) {
                $table->timestamp('search_date')->nullable();
            }
            if (!Schema::hasColumn('search_notifications', 'notified')) {
                $table->boolean('notified')->default(false);
            }
            if (!Schema::hasColumn('search_notifications', 'notification_date')) {
                $table->timestamp('notification_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('search_notifications', function (Blueprint $table) {
            //
        });
    }
};
