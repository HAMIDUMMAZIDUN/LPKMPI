<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingProgram extends Model
{
    protected $table = 'training_programs';

    protected $keyType = 'string';
    
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'category',
        'duration',
        'description',
        'benefits',
        'price',
        'lsp_keyword',
    ];

    protected $casts = [
        'benefits' => 'array',
    ];

    /**
     * Get enrollments for this program.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(TraineeEnrollment::class, 'training_program_id');
    }
}
