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
        return view('api-piekluve.api-requests', compact('requests'));
    }

    public function showForm()
    {
        return view('api-piekluve.api-form');
    }

    public function requestAccess(Request $request)
    {
        $request->validate([
            'device_type' => 'required|string|max:50',
            'device_os'   => 'required|string|max:50',
            'email'       => 'required|email|max:255|unique:api_requests,email',
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
        $apiRequest = ApiRequest::with('apiKey')->findOrFail($id);

        $apiRequest->update(['blocked' => true]);

        $msg = 'Device blocked. The API key is now unusable.';
        
        if ($request->wantsJson()) {
            return response()->json(['message' => $msg]);
        }

        return redirect()->back()->with('success', $msg);
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
        $keyValue = $request->header('X-API-KEY') ?? $request->query('api_key');
        
        $apiKey = \App\Models\ApiKey::with('request')->where('key', $keyValue)->first();

        if (!$apiKey) {
            return response()->json(['error' => 'Invalid or missing API key'], 401);
        }

        if ($apiKey->request->blocked) {
            return response()->json(['error' => 'Your access has been blocked'], 403);
        }

        $pieturas = Pieturas::latest()->get();

        if ($pieturas->isEmpty()) {
            return response()->json(['error' => 'No pieturas found'], 404);
        }

        return PieturasResource::collection($pieturas);
    }
}
