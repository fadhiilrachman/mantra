<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HookLogs extends Model
{
    protected $hidden = ['id'];
    protected $fillable = ['uuid', 'session_id', 'type', 'data', 'payload'];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($botAgent) {
            // Generate a UUID before creating the record
            $botAgent->uuid = Str::uuid();
        });
    }
}
