<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ChatGPTService
{
    protected $apiHost;
    protected $apiKey;

    public function __construct()
    {
        $this->apiHost = config('services.chatgpt.api_host');
        $this->apiKey = config('services.chatgpt.api_key');
    }

    public function chat($prompt)
    {
        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])->post($this->apiHost, [
                    "prompt" => $prompt,
                    "max_tokens" => 1000,
                    "temperature" => 0.5
                ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $response->json()['choices'][0]['text'] ?? 'Maaf, boleh diulangi?';
    }
}