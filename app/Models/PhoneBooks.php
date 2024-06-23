<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PhoneBooks extends Model
{
    protected $fillable = ['uuid', 'user_id', 'title'];

    public function contacts()
    {
        return $this->hasMany(PhoneContacts::class, 'book_id');
    }

    public function botAgents()
    {
        return $this->belongsToMany(BotAgents::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($botAgent) {
            // Generate a UUID before creating the record
            $botAgent->uuid = Str::uuid();
        });

        // Cascade delete phone contacts when a phone book is deleted
        static::deleting(function (PhoneBooks $phoneBook) {
            $phoneBook->contacts()->delete();
            $phoneBook->botAgents()->detach();
        });
    }
}
