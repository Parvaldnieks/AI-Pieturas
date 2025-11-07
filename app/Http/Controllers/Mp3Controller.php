<?php

namespace App\Http\Controllers;

use App\Models\Vesture;
use Illuminate\Http\Request;
use App\Jobs\GenerateMp3Job;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class Mp3Controller extends Controller
{
    public function index()
    {
        $latestIds = Vesture::selectRaw('MAX(id) as id')
            ->groupBy('pieturas_id')
            ->pluck('id');

        $mp3 = Vesture::whereIn('id', $latestIds)
            ->orderByDesc('created_at')
            ->get();

        return view('mp3.index', compact('mp3'));
    }

    public function download($id)
    {
        $vesture = Vesture::findOrFail($id);

        if (!$vesture->mp3_path || !Storage::disk('public')->exists($vesture->mp3_path)) {
            abort(404, 'MP3 file not found.');
        }
                
        $filePath = Storage::disk('public')->path($vesture->mp3_path);
        $downloadName = basename($vesture->mp3_path);


        return response()->download($filePath, $downloadName, [
            'Content-Type' => 'audio/mpeg',
        ]);
    }

    public function start(Request $request)
    {
        $latestIds = Vesture::selectRaw('MAX(id) as id')
            ->groupBy('pieturas_id')
            ->pluck('id');

        $latest = Vesture::whereIn('id', $latestIds)->get();

        $jobs = [];

        foreach ($latest as $v) {
            $previous = Vesture::where('pieturas_id', $v->pieturas_id)
                ->where('id', '<', $v->id)
                ->orderByDesc('id')
                ->first();

            if ($previous && $previous->text !== $v->text) {
                $jobs[] = new GenerateMp3Job($v->id);
            }
        }

        if (empty($jobs)) {
            return back()->with('success', 'Viss ir jau sinhronizēts. Nekas nav jāatjauno.');
        }

        $batch = Bus::batch($jobs)
            ->name('MP3 sync for latest pieturas')
            ->onQueue('mp3-generation')
            ->dispatch();

        return back()->with('success', "Sinhronizācija sākta. Queued: {$batch->totalJobs} faili.");
    }
}
