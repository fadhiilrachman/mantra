<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneBooks;
use App\Models\BotAgents;
use App\Models\HookLogs;
use App\Services\WhatsAppService;
use App\Services\SimSimiService;
use App\Services\ChatGPTService;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected $waSvc;

    public function __construct(
        WhatsAppService $whatsAppService,
        SimSimiService $simSimiService,
        ChatGPTService $chatGPTService
        )
    {
        $this->waSvc = $whatsAppService;
        $this->simSvc = $simSimiService;
        $this->gptSvc = $chatGPTService;
    }

    public function whatsapp(Request $request)
    {
        $apiKey = $request->header('x-api-key');
        if ($apiKey !== config('services.whatsapp.api_key')) {
            abort(403);
        }

        // get bot agent by session id, and active
        $bot = BotAgents::where([
            'uuid' => $request->sessionId,
        ]);
        if (!$bot->first()) {
            abort(404);
        }

        $log = HookLogs::create([
            'session_id' => $request->sessionId,
            'type' => $request->dataType,
            'data' => json_encode($request->data),
            'payload' => json_encode($request->all()),
        ]);

        // run type..
        switch ($request->dataType) {
            case 'authenticated':
                $bot->update([
                    'is_active' => true,
                    'current_status' => $request->dataType,
                ]);

                $this->sendGreetings($request->sessionId);
                break;

            case 'message':
                $bot->update([
                    'current_status' => $request->dataType,
                ]);

                $this->replyMessage($request->sessionId, $request->data);
                break;

            case 'disconnected':
                $bot->update([
                    'is_active' => false,
                    'current_status' => $request->dataType,
                ]);
                break;

            case 'auth_failure':
                $bot->update([
                    'is_active' => false,
                    'current_status' => $request->dataType,
                ]);
                break;

            default:
                $bot->update([
                    'current_status' => $request->dataType,
                ]);
                break;
        }

        return 'OK';
    }

    function sendGreetings($sessionId)
    {
        $botAgent = BotAgents::where('uuid', $sessionId)->first();
        // get all phonebooks from bot and contact
        $contacts = PhoneContacts::select('number')->whereIn('id', $botAgent->phoneBooks->pluck('id'))->get();
        $greetingMsg = 'Halo kak..';

        foreach ($contacts->pluck('number') as $contact) {
            $msgData = [
                "chatId" => $contact . "@c.us",
                "contentType" => "string",
                "content" => $greetingMsg
            ];

            $sendMsg = $this->waSvc->post("client/sendMessage/{$sessionId}", $msgData);
        }
    }

    // note: under development
    function replyMessage($sessionId, $data)
    {
        $botAgent = BotAgents::where('uuid', $sessionId)->first();
        // get msg content from sender
        // $senderName = $data['message']['_data']['notifyName'];
        $senderFrom = $data['message']['from'];
        $senderMsg = $data['message']['body'];
        $msgType = $data['message']['type'];
        if ($senderMsg!==null && $msgType == 'chat' && $senderFrom=="62xxxx@c.us") {
            switch ($botAgent->conversation_model) {
                case 'chatgpt':
                    $msgRep = $this->gptSvc->chat($senderMsg);

                    break;
                case 'simsimi':
                    $msgRep = $this->simSvc->talk('v1/simtalk', $senderMsg);

                    break;

                default:
                    $msgRep = 'Iya';
                    break;
            }

            $msgData = [
                "chatId" => $senderFrom,
                "contentType" => "string",
                "content" => $msgRep
            ];
            $sendMsg = $this->waSvc->post("client/sendMessage/{$sessionId}", $msgData);

            $log = HookLogs::create([
                'session_id' => $sessionId,
                'type' => 'sendMessage',
                'data' => json_encode($data),
                'payload' => json_encode($data),
            ]);
        }
    }
}