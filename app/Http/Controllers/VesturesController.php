<?php

namespace App\Http\Controllers;

use App\Models\Vesture;
use Illuminate\Http\Request;

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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'text' => ['required', 'max:255'],
            'time' => ['required'],
        ]);

        $vesture = vesture::findOrFail($id);
        $vesture->update($data);

        return redirect()->route('vestures.index');
    }

    public function destroy($id)
    {
        $vesture = Vesture::findOrFail($id);
        $vesture->delete();

        return redirect()->route('vestures.index');
    }
}
