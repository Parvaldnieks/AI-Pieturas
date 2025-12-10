<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Pieturas;
use App\Models\PendingKey;
use App\Models\ApiRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PieturasResource;

class ApiAccessController extends Controller
{
    public function index()
    {
        $requests = ApiRequest::with('apiKey')->orderBy('created_at', 'desc')->get();

        return view('api-piekluve.requests', compact('requests'));
    }

    public function showForm()
    {
        return view('api-piekluve.form');
    }

    public function requestAccess(Request $request)
    {
        $request->validate([
            'device_type' => 'required|string|max:50',
            'device_os'   => 'required|string|max:50',
            'email'       => 'required|email|max:255|unique:api_pieprasijums,email',
            'note'        => 'required|string|max:100',
        ], [
            'device_type.required' => 'Device type is required',
            'device_os.required' => 'Device OS is required',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email address',
            'email.unique' => 'Email address is already in use',
            'note.required' => 'Note is required',
            'note.max' => 'Note is too long',
        ]);

        $apiRequest = ApiRequest::create([
            'device_type' => $request->device_type,
            'device_os'   => $request->device_os,
            'email'       => $request->email,
            'note'        => $request->note,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message'    => 'Access request submitted. Await approval.',
                'request_id' => $apiRequest->id,
                'time'       => time(),
            ]);
        }

        return redirect()->back()->with('success', 'Access request submitted.');
    }

    public function approveAccess(Request $request, $id)
    {
        $apiRequest = ApiRequest::findOrFail($id);

        if ($apiRequest->status === 'denied' || $apiRequest->blocked) {
            $msg = 'Cannot generate key for denied or blocked request';
            return $request->wantsJson()
                ? response()->json(['error' => $msg])
                : redirect()->back()->with('error', $msg);
        }

        if ($apiRequest->apiKey) {
            $apiRequest->apiKey->delete();
        }

        $newKey = bin2hex(random_bytes(16));
        $apiRequest->apiKey()->create(['key' => $newKey]);

        $expiresAt = now()->addDay();

        PendingKey::updateOrCreate(
            ['email' => $apiRequest->email],
            [
                'api_key' => $newKey,
                'expires_at' => $expiresAt,
                'copied' => false,
            ]
        );

        $apiRequest->update(['status' => 'approved']);

        $pickupUrl = route('pickup.form');

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'API key generated',
                'api_key' => $newKey
            ]);
        }

        return redirect()->back()->with('pickup_link', $pickupUrl);
    }

    public function denyAccess(Request $request, $id)
    {
        $apiRequest = ApiRequest::findOrFail($id);

        if ($apiRequest->status !== 'pending') {
            $msg = 'Request already processed';
            return $request->wantsJson()
                ? response()->json(['error' => $msg])
                : redirect()->back()->with('error', $msg);
        }

        $apiRequest->update(['status' => 'denied']);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Request denied']);
        }

        return redirect()->back();
    }

    public function deleteKey(Request $request, $id)
    {
        $apiRequest = ApiRequest::with('apiKey')->findOrFail($id);

        if ($apiRequest->apiKey) {
            $apiRequest->apiKey->delete();
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'API key deleted']);
        }

        return redirect()->back();
    }

    public function blockDevice(Request $request, $id)
    {
        $apiRequest = ApiRequest::with('apiKey')->findOrFail($id);

        $apiRequest->update(['blocked' => true]);

        $msg = 'Device blocked. The API key is now unusable.';
        
        if ($request->wantsJson()) {
            return response()->json(['message' => $msg]);
        }

        return redirect()->back();
    }

    public function unblockDevice(Request $request, $id)
    {
        $apiRequest = ApiRequest::findOrFail($id);
        $apiRequest->update(['blocked' => false]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Device unblocked']);
        }

        return redirect()->back();
    }

    public function getPieturas(Request $request)
    {
        $keyValue = $request->header('X-API-KEY') ?? $request->query('api_key');

        $pending = PendingKey::where('api_key', $keyValue)->first();

        if (!$pending) {
            return response()->json(['error' => 'Invalid or missing API key']);
        }

        if (!$pending->copied) {
            return response()->json(['error' => 'API key not activated. Copy & confirm first.']);
        }

        $apiRequest = ApiRequest::where('email', $pending->email)->first();

        if (!$apiRequest || $apiRequest->blocked) {
            return response()->json(['error' => 'Access blocked for this key.']);
        }

        if ($apiRequest->status === 'denied') {
            return response()->json(['error' => 'Your request was denied.']);
        }

        if ($pending->expires_at && $pending->expires_at < now()) {
            return response()->json(['error' => 'API key has expired.']);
        }

        $pieturas = Pieturas::latest()->get();

        if ($pieturas->isEmpty()) {
            return response()->json(['error' => 'No pieturas found']);
        }

        return PieturasResource::collection($pieturas);
    }
}
