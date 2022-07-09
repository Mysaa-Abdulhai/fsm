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
        'isAdmin',
        'is_verified'
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
    ];
    public function volunteer_campaign_requests()
    {
        return $this->hasMany(volunteer_campaign_request::class);
    }
    public function donation_campaign_requests()
    {
        return $this->hasMany(donation_campaign_request::class);
    }
    public function volunteer_form()
    {
        return $this->hasOne(volunteer_form::class);
    }
    public function ChatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
    public function user_role()
    {
        return $this->hasMany(user_role::class);
    }
    public function leader()
    {
        return $this->hasOne(leader::class);
    }
    public function volunteers()
    {
        return $this->hasMany(volunteer::class);
    }
}

