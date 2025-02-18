<?php

namespace App\Services;

use OpenAI\Client;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        // Inizializza il client con la chiave API
        $this->client = new Client([
            'api_key' => env('OPENAI_API_KEY'),
        ]);
    }

    public function moderateComment(string $content)
    {
        // Usa l'API di OpenAI per moderare il commento
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Moderate this content for spam or inappropriate language.'],
                ['role' => 'user', 'content' => $content],
            ],
        ]);

        // Restituisci la risposta del modello
        return $response->choices[0]->message->content;
    }
}
