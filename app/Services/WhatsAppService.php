<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $apiHost;
    protected $apiKey;

    public function __construct()
    {
        $this->apiHost = config('services.whatsapp.api_host');
        $this->apiKey = config('services.whatsapp.api_key');
    }

    public function url($endpoint)
    {
        return "{$this->apiHost}/$endpoint";
    }

    public function get($endpoint, $queryParams = [])
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get("{$this->apiHost}/$endpoint", $queryParams);

        return $response->json();
    }

    public function post($endpoint, $data = [])
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->post("{$this->apiHost}/$endpoint", $data);

        return $response->json();
    }

    public function download($endpoint)
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get("{$this->apiHost}/$endpoint");

        if ($response->successful()) {
            return $response->body();
        } else {
            // Handle error
            return null;
        }
    }
}