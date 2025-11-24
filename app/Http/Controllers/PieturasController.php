<?php

namespace App\Http\Controllers;

use App\Models\Pieturas;
use Illuminate\Http\Request;

class PieturasController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $admin = $user->admin;

        $pieturas = Pieturas::orderByDesc('created_at')->get();
        
        return view('pieturas.index', compact('pieturas', 'user_id', 'admin'));
    }

    public function show($id)
    {
        $mp3 = Pieturas::with(['vestures' => function ($query) {
            $query->orderByDesc('time');
        }])->findOrFail($id);

        $pietura = Pieturas::with(['vestures' => function ($query) {
            $query->orderByDesc('time');
        }])->findOrFail($id);
        
        return view('pieturas.show', compact('pietura', 'mp3'));
    }

    public function create()
    {
        return view('pieturas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
            'text' => ['required', 'max:100', 'regex:/^[a-zA-ZāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ\s!?,.]+$/u'],
        ]);

        $data['user_id'] = auth()->id();

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
            'text' => ['required', 'max:100', 'regex:/^[a-zA-ZāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ\s!?,.]+$/u'],
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
