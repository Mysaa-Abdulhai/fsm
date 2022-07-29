<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_verified',
        'verification_code',
        'code_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_code'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function volunteer_campaign_requests()
    {
        return $this->hasMany(volunteer_campaign_request::class);
    }
    public function donation_campaign_requests()
    {
        return $this->hasMany(donation_campaign_request::class);
    }
    public function ChatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
    public function user_role()
    {
        return $this->hasMany(user_role::class);
    }

    public function volunteers()
    {
        return $this->hasMany(volunteer::class);
    }
    public function notification_tokens()
    {
        return $this->hasMany(notification_token::class);
    }
    public function public_comments()
    {
        return $this->hasMany(public_comment::class);
    }
    public function public_likes()
    {
        return $this->hasMany(public_like::class);
    }
    public function campaign_likes()
    {
        return $this->hasMany(campaign_like::class);
    }
    public function Profile()
    {
        return $this->hasOne(Profile::class);
    }
    //code
    public function generateCode()
    {
        $this->timestamps = false;
        $this->verification_code = rand(100000, 999999);
        $this->code_expires_at = now()->addMinutes(10);
        $this->save();
    }
    public function resetCode()
    {
        $this->timestamps = false;
        $this->verification_code=null;
        $this->code_expires_at=null;

        $this->save();
    }
}

