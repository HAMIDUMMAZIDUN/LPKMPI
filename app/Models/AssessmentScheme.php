<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentScheme extends Model
{
    protected $fillable = ['title', 'description', 'asesor_id', 'status', 'duration_minutes'];

    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'scheme_id')->orderBy('order');
    }

    public function assignments()
    {
        return $this->hasMany(SchemeAssignment::class, 'scheme_id');
    }

    public function attempts()
    {
        return $this->hasMany(AsesiSchemeAttempt::class, 'scheme_id');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
