<?php

namespace App\Http\Controllers;

use App\Models\Mp3;
use Illuminate\Http\Request;

class Mp3Controller extends Controller
{
    public function index()
    {
        $mp3 = Mp3::all();

        return view('mp3.index', compact('mp3'));
    }

    public function create()
    {
        return view('mp3.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
        ]);

        Mp3::create($data);

        return redirect()->route('mp3.index');
    }

    public function edit($id)
    {
        $mp3 = Mp3::findOrFail($id);
        return view('mp3.edit', compact('mp3'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
        ]);

        $mp3 = Mp3::findOrFail($id);
        $mp3->update($data);

        return redirect()->route('mp3.index');
    }

    public function destroy($id)
    {
        $mp3 = Mp3::findOrFail($id);
        $mp3->delete();

        return redirect()->route('mp3.index');
    }
}
