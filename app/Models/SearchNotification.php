<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'chassis_number',
        'user_email',
        'search_date',
        'notified',
        'notification_date'
    ];

    protected $casts = [
        'search_date' => 'datetime',
        'notification_date' => 'datetime',
        'notified' => 'boolean'
    ];

    /**
     * Get the car associated with this notification
     */
    public function car()
    {
        return $this->belongsTo(Car::class, 'chassis_number', 'chassis_number');
    }

    /**
     * Get the police station for the car
     */
    public function policeStation()
    {
        return $this->car->policeStation ?? null;
    }

    /**
     * Scope to get pending notifications for a chassis number
     */
    public function scopePendingForChassis($query, $chassisNumber)
    {
        return $query->where('chassis_number', $chassisNumber)
                    ->where('notified', false);
    }

    /**
     * Mark notification as sent
     */
    public function markAsNotified()
    {
        $this->update([
            'notified' => true,
            'notification_date' => now()
        ]);
    }
}
