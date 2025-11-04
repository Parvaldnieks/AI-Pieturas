<?php

namespace App\Http\Controllers;

use App\Models\Vesture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VesturesController extends Controller
{
    public function index()
    {
        $vestures = vesture::all();

        return view('vestures.index', compact('vestures'));
    }

    public function edit($id)
    {
        $vesture = vesture::findOrFail($id);
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
            'text' => ['required', 'max:255'],
            'time' => ['required'],
            'file' => ['nullable', 'file', 'mimes:mp3', 'max:20480'],
        ]);

        $vesture = Vesture::findOrFail($id);

        $vesture->text = $data['text'];
        $vesture->time = $data['time'];

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
