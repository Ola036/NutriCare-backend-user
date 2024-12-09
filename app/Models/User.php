<?php

namespace App\Models;

use App\Notifications\Authentication\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'reset_code',
        '2FA',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        '2FA'
    ];

    /**
     * The accessors to append to the model's array form.
     * 
     * @var array
     */
    protected $appends = ['has_TwoFA'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['information'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Check if there is 2FA or not
     * 
     * @return bool
     */
    public function getHasTwoFAAttribute()
    {
        return (bool) $this->{'2FA'};
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function information()
    {
        return $this->hasOne(UserInformation::class);
    }
}
