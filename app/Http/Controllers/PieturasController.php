<?php

namespace App\Http\Controllers;

use App\Models\Pieturas;
use Illuminate\Http\Request;

class PieturasController extends Controller
{
    public function index()
    {
        $pieturas = Pieturas::orderByDesc('created_at')->get();

        return view('pieturas.index', compact('pieturas'));
    }

    public function show($id)
    {
        $pietura = Pieturas::findOrFail($id);
        return view('pieturas.show', compact('pietura'));
    }

    public function create()
    {
        return view('pieturas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
            'text' => ['required', 'max:255', 'regex:/^[a-zA-ZāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ\s!?,.]+$/u'],
        ], [
            'name.required' => __('Nosaukums ir nepieciešams!'),
            'name.max' => __('Nosaukums nedrīkst pārsniegt 50 rakstzīmes!'),
            'text.required' => __('Teksts ir nepieciešams!'),
            'text.max' => __('Teksts nedrīkst pārsniegt 255 rakstzīmes!'),
            'text.regex' => __('Teksts nedrīkst saturēt ciparus!'),
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
            'text' => ['required', 'max:255', 'regex:/^[a-zA-ZāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ\s!?,.]+$/u'],
        ], [
            'name.required' => __('Nosaukums ir nepieciešams!'),
            'name.max' => __('Nosaukums nedrīkst pārsniegt 50 rakstzīmes!'),
            'text.required' => __('Teksts ir nepieciešams!'),
            'text.max' => __('Teksts nedrīkst pārsniegt 255 rakstzīmes!'),
            'text.regex' => __('Teksts nedrīkst saturēt ciparus!'),
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
