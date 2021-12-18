<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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

    /**
     * Get all invite codes of user.
     */
    public function invite_codes()
    {
        return $this->hasMany(InviteCode::class);
    }

    /**
     * Get owner of user. who generate invitation code for this person.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get all people of person
     */
    public function people()
    {
        return $this->hasMany(User::class, 'owner_id', 'id');
    }

    /**
     * Get entry of user
     */
    public function entry()
    {
        return $this->hasOne(Entry::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
