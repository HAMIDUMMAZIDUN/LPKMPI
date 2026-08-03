<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'institution',
        'position',
        'purpose',
        'meet_with',
        'notes',
    ];
}
