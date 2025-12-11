<?php

namespace App\Http\Controllers;

use App\Models\Vesture;
use App\Models\PendingKey;
use App\Models\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SecureMp3Controller extends Controller
{
    public function stream(Request $request, Vesture $vesture)
    {
        if (auth()->check()) {
            return $this->serveFile($vesture);
        }

        $apiKey = $request->query('api_key');

        if (!$apiKey || trim($apiKey) === '') {
            abort(403, 'API key required');
        }

        $pending = PendingKey::where('api_key', $apiKey)->first();

        if (!$pending) {
            abort(403, 'Invalid API key');
        }

        if (!$pending->copied) {
            abort(403, 'API key not activated. Copy & confirm in pickup form.');
        }

        if ($pending->expires_at && $pending->expires_at < now()) {
            abort(403, 'API key expired');
        }

        $requestRecord = ApiRequest::where('email', $pending->email)->first();

        if (!$requestRecord) {
            abort(403, 'API request not found. Key is invalid.');
        }

        if ($requestRecord->blocked) {
            abort(403, 'API key blocked');
        }

        if ($requestRecord->status === 'denied') {
            abort(403, 'API key denied');
        }

        return $this->serveFile($vesture);
    }

    private function serveFile(Vesture $vesture)
    {
        if (!$vesture->mp3_path || !Storage::disk('public')->exists($vesture->mp3_path)) {
            abort(404, 'MP3 not found.');
        }

        return response()->file(
            Storage::disk('public')->path($vesture->mp3_path),
            ['Content-Type' => 'audio/mpeg']
        );
    }
}
