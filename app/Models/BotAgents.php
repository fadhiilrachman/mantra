<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Services\WhatsAppService;

class BotAgents extends Model
{
    protected $hidden = ['id'];
    protected $fillable = ['uuid', 'user_id', 'conversation_model', 'is_active', 'whatsapp_number'];

    public function phoneBooks()
    {
        return $this->belongsToMany(PhoneBooks::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($botAgent) {
            // Generate a UUID before creating the record
            $botAgent->uuid = Str::uuid();
        });

        static::deleting(function ($botAgent) {
            $responseStatusSession = (new WhatsAppService())->get("session/status/{$botAgent->uuid}");
            if ($responseStatusSession['message'] !== 'session_not_found') {
                $terminate = (new WhatsAppService())->get("session/terminate/{$botAgent->uuid}");
                if ($terminate['success'] !== true) {
                    return false;
                }
            }
        });
    }
}
