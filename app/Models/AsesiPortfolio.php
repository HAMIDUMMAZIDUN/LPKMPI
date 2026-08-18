<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsesiPortfolio extends Model
{
    protected $table = 'asesi_portfolios';

    protected $fillable = ['user_id', 'training_program_id', 'document_name', 'file_path', 'status', 'notes'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trainingProgram(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program_id');
    }
}
