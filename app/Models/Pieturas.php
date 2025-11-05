<?php

namespace App\Models;

use App\Models\Vesture;
use App\Services\TextToSpeechService;
use Illuminate\Database\Eloquent\Model;

class Pieturas extends Model
{
    protected $fillable = [
        'name',
        'text',
    ];

    public function vestures()
    {
        return $this->hasMany(Vesture::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($pietura) {
            $tts = new TextToSpeechService();
            $mp3Path = $tts->generateMp3($pietura->name, $pietura->text);

            Vesture::create([
                'pieturas_id' => $pietura->id,
                'name' => $pietura->name,
                'text' => $pietura->text,
                'time' => time(), // Unix laiks
                'mp3_path' => $mp3Path,
            ]);
        });

        static::updated(function ($pietura) {
            Vesture::create([
                'pieturas_id' => $pietura->id,
                'name' => $pietura->name,
                'text' => $pietura->text,
                'time' => time(), // Unix laiks
            ]);
        });
    }
}
