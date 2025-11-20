<?php

namespace App\Services;

use OpenAI;

class OpenAITranslator
{
    public function translate(string $text, string $from, string $to, string $prompt = null): string
    {
        $text = trim($text);
        if ($text === '') {
            return '';
        }

        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $response = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Translate the following UI text from {$from} to {$to}. 
                    Return ONLY the translated text, without quotes or explanations.",
                ],
                [
                    'role' => 'user',
                    'content' => $text,
                ],
            ],
        ]);

        $content = $response->choices[0]->message->content ?? $text;

        return trim($content);
    }
}
