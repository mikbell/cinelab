<?php

namespace App\Ai;

use OpenAI\Laravel\Facades\OpenAI;

class Assistant
{
    protected array $messages = [];

    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }

    public function context(string $message): static
    {
        $this->addMessage('system', $message);

        return $this;
    }

    public function send(string $message, bool $speech = false): ?string
    {

        $this->addMessage('user', $message);

        $response = OpenAI::chat()->create([
            "model" => "gpt-4o-mini",
            "messages" => $this->messages
        ])->choices[0]->message->content;


        $this->addMessage('assistant', $response);

        return $speech ? $this->speech($response) : $response;
    }

    public function speech(string $message): string
    {
        return OpenAI::audio()->speech([
            "model" => "tts-1",
            "input" => $message,
            "voice" => "alloy"
        ]);
    }

    public function reply(string $message): ?string
    {
        return $this->send($message);
    }

    public function visualize(string $description, array $options = []): ?string
    {
        $this->addMessage('user', $description);

        $description = collect($this->messages)->where('role', 'user')->pluck('content')->implode(" ");

        $options = array_merge([
            "prompt" => $description,
            "model" => "dall-e-3",
        ], $options);

        $url = OpenAI::images()->create($options)->data[0]->url;

        $this->addMessage('assistant', $url);

        return $url;
    }

    protected function addMessage(string $role, string $content)
    {
        $this->messages[] = [
            'role' => $role,
            'content' => $content
        ];
    }

    public function messages(): array
    {
        return $this->messages;
    }
}