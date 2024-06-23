<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PhoneContacts extends Model
{
    protected $hidden = ['id'];
    protected $fillable = ['uuid', 'user_id', 'book_id', 'number', 'name'];

    public function book()
    {
        return $this->belongsTo(PhoneBooks::class, 'book_id');
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
    }
}
