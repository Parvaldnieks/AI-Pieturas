<?php

namespace App\Http\Controllers;

use App\Models\Pieturas;
use App\Models\ApiRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PieturasResource;

class ApiAccessController extends Controller
{
    public function index()
    {
        $requests = ApiRequest::with('apiKey')->orderBy('created_at', 'desc')->get();
        return view('api-requests', compact('requests'));
    }

    public function requestAccess(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string|max:255',
            'requester_email' => 'nullable|email'
        ]);

        $apiRequest = ApiRequest::create([
            'device_name' => $request->device_name,
            'requester_email' => $request->requester_email,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Access request submitted. Await approval.',
                'request_id' => $apiRequest->id
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
                ? response()->json(['error' => $msg], 400)
                : redirect()->back()->with('error', $msg);
        }

        if ($apiRequest->apiKey) {
            $apiRequest->apiKey->delete();
        }

        $key = bin2hex(random_bytes(16));
        $apiRequest->apiKey()->create(['key' => $key]);
        $apiRequest->update(['status' => 'approved']);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'API key generated', 'api_key' => $key]);
        }

        return redirect()->back()->with('success', 'API key generated: ' . $key);
    }

    public function denyAccess(Request $request, $id)
    {
        $apiRequest = ApiRequest::findOrFail($id);

        if ($apiRequest->status !== 'pending') {
            $msg = 'Request already processed';
            return $request->wantsJson()
                ? response()->json(['error' => $msg], 400)
                : redirect()->back()->with('error', $msg);
        }

        $apiRequest->update(['status' => 'denied']);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Request denied']);
        }

        return redirect()->back()->with('success', 'Request denied');
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

        return redirect()->back()->with('success', 'API key deleted.');
    }

    public function blockDevice(Request $request, $id)
    {
        $apiRequest = ApiRequest::findOrFail($id);

        if ($apiRequest->apiKey) {
            $apiRequest->apiKey->delete();
        }

        $apiRequest->update(['blocked' => true]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Device blocked']);
        }

        return redirect()->back()->with('success', 'Device blocked.');
    }

    public function unblockDevice(Request $request, $id)
    {
        $apiRequest = ApiRequest::findOrFail($id);
        $apiRequest->update(['blocked' => false]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Device unblocked']);
        }

        return redirect()->back()->with('success', 'Device unblocked.');
    }

    public function getPieturas(Request $request)
    {
        $pieturas = Pieturas::latest()->get();

        if ($pieturas->isEmpty()) {
            return response()->json(['error' => 'No pieturas found'], 404);
        }

        return PieturasResource::collection($pieturas);
    }
}
