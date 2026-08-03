<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->username)) {
                if (!empty($user->email)) {
                    $baseUsername = explode('@', $user->email)[0];
                } else {
                    $baseUsername = 'user';
                }
                $username = $baseUsername;
                $counter = 1;
                while (static::where('username', $username)->exists()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }
                $user->username = $username;
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** Skema penilaian yang dibuat oleh asesor ini */
    public function schemes()
    {
        return $this->hasMany(\App\Models\AssessmentScheme::class, 'asesor_id');
    }

    /** Attempts pengerjaan oleh asesi ini */
    public function attempts()
    {
        return $this->hasMany(\App\Models\AsesiSchemeAttempt::class, 'asesi_id');
    }

    public function isSuperadmin(): bool { return $this->role === 'superadmin'; }
    public function isAdmin(): bool      { return $this->role === 'admin'; }
    public function isAsesor(): bool     { return $this->role === 'asesor'; }
    public function isAsesi(): bool      { return $this->role === 'asesi'; }
}
