<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage',
        'ref1',
        'ref2'
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

    public function parent_user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSiblingEntry()
    {
        if ($this->sibling == null) {
            return null;
        }

        $siblingEntry = $this->sibling->entry;

        if ($siblingEntry->stage == $this->stage) {
            return $siblingEntry;
        } else {
            return null;
        }

        // return $this->parent_user()->people()->where('stage', $this->stage)->whereNotIn('id', [$this->id])->first();
    }

    public function sibling()
    {
        return $this->belongsTo(User::class);
    }

    public function ref1_user()
    {
        return $this->belongsTo(User::class, 'ref1');
    }

    public function ref2_user()
    {
        return $this->belongsTo(User::class, 'ref2');
    }

}

