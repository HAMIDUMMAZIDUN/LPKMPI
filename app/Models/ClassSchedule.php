<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $table = 'class_schedules';

    protected $fillable = [
        'training_program_id',
        'asesor_id',
        'topic',
        'scheduled_at',
        'location',
        'type',           // 'online' or 'offline'
        'online_link',    // Zoom/Meet link for online sessions
        'share_location', // Google Maps link for offline sessions
        'notification_sent',
    ];

    protected $casts = [
        'scheduled_at'      => 'datetime',
        'notification_sent' => 'boolean',
    ];

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }
}
