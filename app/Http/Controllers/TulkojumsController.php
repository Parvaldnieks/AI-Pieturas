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
        $originals = Originals::with(['tulkojumi' => function ($q) use ($valoda) {
            $q->where('valodas_id', $valoda->id);
        }])->orderBy('key')->get();

        $rows = $originals->map(function ($original) use ($valoda) {
            $parts = explode('.', $original->key);

            $group = $parts[0] ?? '';
            $view  = $parts[1] ?? '';
            $field = implode('.', array_slice($parts, 2));

            $translation = optional(
                $original->tulkojumi->first()
            )->translation;

            return [
                'id'          => $original->id,
                'key'         => $original->key,
                'group'       => $group,
                'view'        => $view,
                'field'       => $field,
                'original'    => $original->text,
                'translation' => $translation ?? '',
            ];
        });

        return view('tulkojums.index', [
            'valoda' => $valoda,
            'rows'   => $rows,
        ]);
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
            'translation' => 'required|string'
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
