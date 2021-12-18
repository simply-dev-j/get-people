<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function super_entry()
    {
        return $this->belongsTo(Entry::class, 'owner_id')->where('stage', $this->stage);
    }

    public function sub_entries()
    {
        return $this->hasMany(Entry::class, 'owner_id')->where('stage', $this->stage);;
    }
}
