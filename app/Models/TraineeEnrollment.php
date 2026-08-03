<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraineeEnrollment extends Model
{
    protected $table = 'trainee_enrollments';

    protected $fillable = [
        'training_program_id',
        'name',
        'nik',
        'email',
        'phone',
        'education',
        'category',
        'company',
        'position',
        'ktp_path',
        'ijazah_path',
        'payment_method',
        'payment_status',
        'payment_reference',
        'payment_amount',
        'certificate_number',
        'certificate_date',
        'status',
    ];

    protected $casts = [
        'certificate_date' => 'date',
    ];

    /**
     * Get the training program this trainee is enrolled in.
     */
    public function trainingProgram(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program_id');
    }
}
