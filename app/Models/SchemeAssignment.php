<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeAssignment extends Model
{
    protected $fillable = ['scheme_id', 'asesor_id', 'assigned_by', 'assigned_at'];

    protected $casts = ['assigned_at' => 'datetime'];

    public function scheme()
    {
        return $this->belongsTo(AssessmentScheme::class, 'scheme_id');
    }

    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function assignedByUser()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
