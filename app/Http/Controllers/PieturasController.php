<?php

namespace App\Http\Controllers;

use App\Models\Pieturas;
use Illuminate\Http\Request;

class PieturasController extends Controller
{
    public function index()
    {
        $pieturas = Pieturas::all();

        return view('pieturas.index', compact('pieturas'));
    }

    public function create()
    {
        return view('pieturas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
            'text' => ['required', 'max:255'],
        ]);

        Pieturas::create($data);

        return redirect()->route('pieturas.index');
    }

    public function edit($id)
    {
        $pietura = Pieturas::findOrFail($id);
        return view('pieturas.edit', compact('pietura'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
            'text' => ['required', 'max:255'],
        ]);

        $pietura = Pieturas::findOrFail($id);
        $pietura->update($data);

        return redirect()->route('pieturas.index');
    }

    public function destroy($id)
    {
        $pietura = Pieturas::findOrFail($id);
        $pietura->delete();

        return redirect()->route('pieturas.index');
    }
}
