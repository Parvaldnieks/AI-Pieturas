<?php

namespace App\Jobs;

use App\Models\Originals;
use App\Models\Tulkojums;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use App\Services\OpenAITranslator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TranslateOriginalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public int $tries = 3;
    public int $backoff = 10;

    protected int $originalId;
    protected int $languageId;
    protected string $languageCode;

    public function __construct(int $originalId, int $languageId, string $languageCode)
    {
        $this->originalId   = $originalId;
        $this->languageId   = $languageId;
        $this->languageCode = $languageCode;
    }

    public function handle(OpenAITranslator $translator): void
    {
        $original = Originals::find($this->originalId);

        if (! $original) {
            return;
        }

        $exists = Tulkojums::where('originals_id', $this->originalId)
            ->where('valodas_id', $this->languageId)
            ->exists();

        if ($exists) {
            return;
        }

        $translated = $translator->translate(
            $original->text,
            'Latvian',
            $this->languageCode
        );

        Tulkojums::updateOrCreate(
            [
                'originals_id' => $this->originalId,
                'valodas_id'   => $this->languageId,
            ],
            [
                'translation'  => $translated,
            ]
        );
    }
}
