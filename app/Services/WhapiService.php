<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhapiService
{
    protected $baseUrl;
    protected $token;
    protected $channel;

    public function __construct()
    {
        $this->baseUrl = rtrim(env('WHAPI_BASE_URL'), '/');
        $this->token = env('WHAPI_TOKEN');
        $this->channel = env('WHAPI_CHANNEL');
    }

    public function enviarMensaje($telefono, $mensaje)
    {
        $url = "{$this->baseUrl}/messages/text";

        $response = Http::withToken($this->token)
            ->post($url, [
                'to' => $telefono,
                'body' => $mensaje,
            ]);

        // Log para debugging
        \Log::info('Whapi Response', [
            'status' => $response->status(),
            'body' => $response->json()
        ]);

        return $response;
    }
}
