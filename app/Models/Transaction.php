<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'current_amount',
        'money_type'
    ];

    public function reference_user() {
        return $this->belongsTo(User::class);
    }

    public function reference_user2() {
        return $this->belongsTo(User::class);
    }
}
