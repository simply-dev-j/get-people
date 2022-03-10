<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'case',
        'block_until_time'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
