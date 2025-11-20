<?php

namespace App\Http\Controllers;

use App\Models\Valodas;
use App\Models\Originals;
use App\Models\Tulkojums;
use Illuminate\Http\Request;

class TulkojumsController extends Controller
{
    public function index(Valodas $valoda)
    {
        $originals = Originals::with([
            'tulkojumi' => function($q) use ($valoda) {
                $q->where('valodas_id', $valoda->id);
            }
        ])
        ->orderBy('key')
        ->get();

        return view('tulkojums.index', compact('valoda', 'originals'));
    }

    public function edit(Request $request, Valodas $valoda, Originals $original)
    {
        $tulkojums = Tulkojums::firstOrNew([
            'originals_id' => $original->id,
            'valodas_id'   => $valoda->id,
        ]);

        return view('tulkojums.edit', compact('valoda', 'original', 'tulkojums'));
    }

    public function update(Request $request, Valodas $valoda, Originals $original)
    {
        $request->validate([
            'translation' => 'nullable|string'
        ]);

        Tulkojums::updateOrCreate(
            [
                'originals_id' => $original->id,
                'valodas_id' => $valoda->id
            ],
            [
                'translation' => $request->translation
            ]
        );

        return back();
    }
}
