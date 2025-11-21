<?php

namespace App\Http\Controllers;

use App\Models\Valodas;
use App\Models\Originals;
use Illuminate\Http\Request;
use App\Jobs\TranslateOriginalJob;
use Illuminate\Support\Facades\Bus;

class ValodasController extends Controller
{
    public function index()
    {
        $originals = Originals::count();

        $valodas = Valodas::withCount([
            'tulkojumi as translated_count' => function ($q) {
                $q->whereNotNull('translation')
                ->where('translation', '!=', '');
            }
        ])
        ->orderBy('name')
        ->get();

        return view('valodas.index', compact('valodas', 'originals'));
    }

    public function create()
    {
        return view('valodas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:10|unique:valodas,code',
        ]);

        Valodas::create([
            'name' => $request->name,
            'code' => strtolower($request->code),
        ]);

        return redirect()->route('valodas.index');
    }

    public function edit(Valodas $valoda)
    {
        return view('valodas.edit', compact('valoda'));
    }

    public function update(Request $request, Valodas $valoda)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:10|unique:valodas,code,' . $valoda->id,
        ]);

        $valoda->update([
            'name' => $request->name,
            'code' => strtolower($request->code),
        ]);

        return redirect()->route('valodas.index');
    }

    public function destroy(Valodas $valoda)
    {
        $valoda->delete();

        return redirect()->route('valodas.index');
    }

    public function start(Valodas $valoda)
    {
        if ($valoda->code === 'lv') {
            return back();
        }

        $jobs = [];

        $originals = Originals::all();

        foreach ($originals as $original) {
            $alreadyTranslated = $original->tulkojumi()
                ->where('valodas_id', $valoda->id)
                ->exists();

            if ($alreadyTranslated) {
                continue;
            }

            $delayPerJob = 2;
            
            $jobs[] = (new TranslateOriginalJob(
                $original->id,
                $valoda->id,
                $valoda->code
            ))->delay($delayPerJob * count($jobs));
        }

        if (empty($jobs)) {
            return back();
        }

        $batch = Bus::batch($jobs)
            ->name("Sync translations for {$valoda->code}")
            ->onQueue('text-translation')
            ->dispatch();

        session(['last_batch' => $batch->id]);

        return back()->with('success', t('valodas.sync.started', 'Sinhronizācija sākta!'));
    }

    public function switch(Request $request)
    {
        $lang = $request->language;

        session(['valoda' => $lang]);

        cookie()->queue('lang', $lang, 60 * 24  *365);
        
        app()->setLocale($lang);

        return back();
    }
}
