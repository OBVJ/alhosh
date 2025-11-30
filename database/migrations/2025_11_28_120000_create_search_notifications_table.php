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
        Schema::create('search_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('chassis_number');
            $table->string('user_email');
            $table->timestamp('search_date')->nullable();
            $table->boolean('notified')->default(false);
            $table->timestamp('notification_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_notifications');
    }
};
