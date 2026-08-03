<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['scheme_id', 'question_text', 'question_type', 'order', 'points'];

    public function scheme()
    {
        return $this->belongsTo(AssessmentScheme::class, 'scheme_id');
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class)->orderBy('order');
    }

    public function correctOption()
    {
        return $this->hasOne(QuestionOption::class)->where('is_correct', true);
    }
}
