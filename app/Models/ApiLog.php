<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $table = 'api_logs';

    // Enable created_at, disable updated_at if not needed, or just let it use normal timestamps.
    // The prompt specifically mentions created_at, so we can support it.
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'endpoint',
        'request_params',
        'response_status',
        'ip_address',
    ];

    protected $casts = [
        'request_params' => 'array',
    ];
}
