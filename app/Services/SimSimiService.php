<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class SimSimiService
{
    protected $apiHost;

    public function __construct()
    {
        $this->apiHost = config('services.simsimi.api_host');
    }

    public function talk($endpoint, $text)
    {
        $formData = [
            'text' => $text,
            'lc' => 'id',
        ];

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $client = new Client();

        try {
            $response = $client->post("{$this->apiHost}/$endpoint", [
                'headers' => $headers,
                'form_params' => array_merge($formData),
            ]);

            $responseData = json_decode($response->getBody(), false);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $responseData->message ?? 'Maaf, boleh diulangi?';
    }
}