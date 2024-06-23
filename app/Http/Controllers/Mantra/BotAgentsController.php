<?php

namespace App\Http\Controllers\Mantra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneBooks;
use App\Models\PhoneContacts;
use App\Models\BotAgents;
use App\Models\HookLogs;
use Auth;
use Validator;
use App\Services\WhatsAppService;

class BotAgentsController extends Controller
{
    protected $waSvc;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->waSvc = $whatsAppService;
    }

    public function registerAgent()
    {
        $phoneBooks = PhoneBooks::select('uuid', 'title')->get();

        return view('mantra.botagents.register', compact('phoneBooks'));
    }

    public function createNewAgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whatsapp_number' => 'required|string',
            'conversation_model' => 'required|string',
            'book_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('mantra.botagents.register')->with('error', $validator->errors()->first());
        }

        $whatsappNumber = $request->input('whatsapp_number');
        $coversationModel = $request->input('conversation_model');
        $bookId = $request->input('book_id');
        $user = Auth::user();

        $botAgent = BotAgents::create([
            'user_id' => $user->id,
            'whatsapp_number' => $whatsappNumber,
            'conversation_model' => $coversationModel,
            'is_active' => false,
        ]);
        $phoneBooks = PhoneBooks::whereIn('uuid', $bookId)->get();
        $botAgent->phoneBooks()->attach($phoneBooks);

        return redirect()->route('mantra.botagents.inactive')->with('success', 'Bot Agent created successfully!');
    }

    public function detailBotJson($uuid)
    {
        $imgUrl = route('mantra.botagents.qrcode', $uuid);
        $botAgent = BotAgents::select('current_status', 'is_active')->where('uuid', $uuid)->first();

        if (!$botAgent) {
            abort(404, 'Bot agent not found.');
        }
        
        return response()->json(['current_status' => $botAgent->current_status, 'is_active' => $botAgent->is_active]);
    }

    public function activateAgent($uuid)
    {
        $imgUrl = route('mantra.botagents.qrcode', $uuid);
        $botAgent = BotAgents::where('uuid', $uuid)->first();

        if (!$botAgent) {
            abort(404, 'Bot agent not found.');
        }
        
        return view('mantra.botagents.activate', compact('imgUrl', 'uuid'));
    }

    public function qrCodeSession($uuid)
    {
        $botAgent = BotAgents::where('uuid', $uuid)->first();

        if (!$botAgent) {
            abort(404, 'Bot agent not found.');
        }
        
        $responseStatusSession = $this->waSvc->get("session/status/{$uuid}");
        if ($responseStatusSession['message'] == 'session_not_connected') {
            $imageData = $this->waSvc->download("session/qr/{$uuid}/image");
        } else if ($responseStatusSession['message'] == 'session_not_found') {
            $responseStartSession = $this->waSvc->get("session/start/{$uuid}");
            if ($responseStartSession['success'] == true) {
                $imageData = $this->waSvc->download("session/qr/{$uuid}/image");
            }
        } else {
            abort(404, 'Bot agent not found.');
        }

        return response($imageData)->header('Content-Type', 'image/jpeg');
    }

    public function activeAgents()
    {
        return view('mantra.botagents.active');
    }

    public function inactiveAgents()
    {
        return view('mantra.botagents.inactive');
    }

    public function deleteAgent($uuid)
    {
        $botAgent = BotAgents::where('uuid', $uuid)->first();

        if (!$botAgent) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => $botAgent->delete() ?? false]);
    }

    public function inactivateAgent($uuid)
    {
        $botAgent = BotAgents::where('uuid', $uuid)->first();

        if (!$botAgent) {
            return response()->json(['success' => false]);
        }

        $responseStatusSession = $this->waSvc->get("session/status/{$botAgent->uuid}");
        if ($responseStatusSession['message'] !== 'session_not_found') {
            $terminate = $this->waSvc->get("session/terminate/{$botAgent->uuid}");
            if ($terminate['success'] !== true) {
                return response()->json(['success' => false]);
            }
        }

        return response()->json(['success' => $botAgent->update(['is_active'=>false]) ?? false]);
    }

    public function logs()
    {
        return view('mantra.botagents.logs');
    }

    public function logDetail($uuid)
    {
        $log = HookLogs::where('uuid', $uuid)->first();

        if (!$log) {
            return response()->json(['success' => false]);
        }

        return view('mantra.botagents.log-detail', compact('log'));
    }
}
