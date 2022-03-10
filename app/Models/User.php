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
        'security_code',
        'id_number',
        'phone',
        'username',
        'bank',
        'bank_number',
        'bank_address',
        'active',
        'is_admin',
        'money_by_invitation',
        'money_by_step',
        'money_by_child_release',
        'withdrawn',
        'released_from_pending',
        'fund_transfer_status',
        'fund_transfer_req_date',
        'money_added',
        'verifier_id',
        'security_case',
        'security_attempt_count',
        'is_company',
        'company_req_date'
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

    protected $with = [
        'owner'
    ];

    /**
     * Get all invite codes of user.
     */
    public function invite_codes()
    {
        return $this->hasMany(InviteCode::class);
    }

    /**
     * Get the invite code which is used to register.
     */
    public function invite_code()
    {
        return $this->belongsTo(InviteCode::class);
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

    public function center()
    {
        return $this->hasOne(Center::class);
    }

    public function security_case($case)
    {
        return $this->hasMany(SecurityCase::class)->firstOrCreate(['case' => $case]);
    }

}
