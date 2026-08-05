<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id',
        'name',
        'email',
        'message',
        'sender_role',
        'admin_id',
        'claimed_by_admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function claimedByAdmin()
    {
        return $this->belongsTo(User::class, 'claimed_by_admin_id');
    }
}
