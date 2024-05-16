<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\ActivityLog\Interface\ActivityLogInterface;
use App\Services\ActivityLog\Model\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kra8\Snowflake\HasSnowflakePrimary;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements ActivityLogInterface
{
    use HasApiTokens, HasFactory, Notifiable, HasSnowflakePrimary;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function booted()
    {
        static::creating(function (User $user) {
            $user->getActivityLogOptions();
        });

        static::updating(function (User $user) {
            $user->getActivityLogOptions();
        });
    }
    public function getActivityLogOptions(): LogActivity
    {
        return LogActivity::log()->setModel($this)->setOperable();
    }
}
