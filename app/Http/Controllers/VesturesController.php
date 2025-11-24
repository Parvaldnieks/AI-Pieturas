<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vesture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VesturesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_id = $user->id;

        if ($user->admin) {
            $vestures = Vesture::orderByDesc('created_at')->get();
        } else {
            $vestures = Vesture::whereHas('pietura', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
            })
            ->orderByDesc('created_at')
            ->get();
        }

        return view('vestures.index', compact('vestures'));
    }

    public function edit($id)
    {
        $vesture = vesture::findOrFail($id);
        $vesture->formatted_time = Carbon::createFromTimestamp($vesture->time, 'Europe/Riga')->format('Y-m-d\TH:i');

        return view('vestures.edit', compact('vesture'));
    }

    public function show($id)
    {
        $vesture = vesture::findOrFail($id);

        return view('vestures.show', compact('vesture'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
            'text' => ['required', 'max:255'],
            'time' => ['required'],
            'file' => ['nullable', 'file', 'mimes:mp3', 'max:20480'],
        ]);

        $vesture = Vesture::findOrFail($id);

        $timestamp = Carbon::parse($data['time'], 'Europe/Riga')->timestamp;

        $vesture->name = $data['name'];
        $vesture->text = $data['text'];
        $vesture->time = $timestamp;

        if ($request->hasFile('file')) {
            if ($vesture->mp3_path) {
                Storage::disk('public')->delete($vesture->mp3_path);
            }

            $path = $request->file('file')->store('mp3s', 'public');
            $vesture->mp3_path = $path;
        }

        $vesture->save();

        return redirect()->route('vestures.index');
    }

    public function destroy($id)
    {
        $vesture = Vesture::findOrFail($id);
        $vesture->delete();

        return redirect()->route('vestures.index');
    }
}
