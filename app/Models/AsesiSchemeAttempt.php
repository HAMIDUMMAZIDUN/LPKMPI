<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesiSchemeAttempt extends Model
{
    protected $fillable = ['asesi_id', 'scheme_id', 'status', 'score', 'started_at', 'completed_at'];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function asesi()
    {
        return $this->belongsTo(User::class, 'asesi_id');
    }

    public function scheme()
    {
        return $this->belongsTo(AssessmentScheme::class, 'scheme_id');
    }

    public function answers()
    {
        return $this->hasMany(AsesiAnswer::class, 'attempt_id');
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Calculate score based on correct multiple choice answers.
     * Assumes answers are already loaded with selectedOption and question relations.
     */
    public function calculateScore(): int
    {
        // Re-load everything fresh to avoid stale relation cache issues
        $answers = $this->answers()
            ->with(['selectedOption', 'question'])
            ->get();

        $scheme = $this->scheme()->with('questions')->first();
        $totalPoints = $scheme->questions->sum('points');

        if ($totalPoints === 0) {
            return 100; // No scored questions → full marks by default
        }

        $earnedPoints = 0;
        foreach ($answers as $answer) {
            if (
                $answer->question &&
                $answer->question->question_type === 'multiple_choice' &&
                $answer->selected_option_id &&
                $answer->selectedOption &&
                $answer->selectedOption->is_correct
            ) {
                $earnedPoints += $answer->question->points;
            }
        }

        return (int) round(($earnedPoints / $totalPoints) * 100);
    }
}
