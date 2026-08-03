<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $table = 'class_schedules';

    protected $fillable = ['training_program_id', 'asesor_id', 'topic', 'scheduled_at', 'location'];

    protected $casts = [
        'scheduled_at' => 'datetime',
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
