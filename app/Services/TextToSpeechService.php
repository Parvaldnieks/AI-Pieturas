<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TextToSpeechService
{
    public function generateMp3(string $name, string $text): ?string
    {
        $apiKey  = env('ELEVENLABS_API_KEY');
        $voiceId = env('ELEVENLABS_VOICE_ID');
        $modelId = env('ELEVENLABS_MODEL_ID');

        $response = Http::withHeaders([
            'xi-api-key'   => $apiKey,
            'Accept'       => 'audio/mpeg',
            'Content-Type' => 'application/json',
        ])->post("https://api.elevenlabs.io/v1/text-to-speech/{$voiceId}/stream", [
            'text'          => $text,
            'model_id'      => $modelId,
            'output_format' => 'mp3_44100_128',
        ]);

        if ($response->successful()) {
            $audioBinary = $response->body();
            $name = Str::slug($name);
            $timestamp = Carbon::now()->format('d-m-Y_H-i-s');
            $filename = "mp3s/{$name}_{$timestamp}_" . Str::random(6) . ".mp3";

            Storage::disk('public')->put($filename, $audioBinary);

            return $filename;
        }

        return null;
    }
}
