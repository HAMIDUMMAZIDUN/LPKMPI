<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesiAnswer extends Model
{
    protected $fillable = ['attempt_id', 'question_id', 'selected_option_id', 'essay_answer'];

    public function attempt()
    {
        return $this->belongsTo(AsesiSchemeAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption()
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id');
    }
}
