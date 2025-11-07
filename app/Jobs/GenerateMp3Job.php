<?php

namespace App\Jobs;

use App\Models\Vesture;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Services\TextToSpeechService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateMp3Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $tries = 3;
    public $backoff = 10;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $vestureId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TextToSpeechService $tts): void
    {
        $vesture = Vesture::find($this->vestureId);
        if (!$vesture) {
            return;
        }

        $mp3Path = $tts->generateMp3($vesture->name, $vesture->text);

        if ($mp3Path) {
            $vesture->update(['mp3_path' => $mp3Path]);
        }
    }
}
