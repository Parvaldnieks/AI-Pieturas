<?php

namespace App\Models;

use App\Models\Vesture;
use App\Services\TextToSpeechService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pieturas extends Model
{
    protected $fillable = [
        'name',
        'text',
        'user_id',
    ];

    protected $appends = ['latest_mp3_path', 'latest_mp3_url'];

    public function vestures()
    {
        return $this->hasMany(Vesture::class, 'pieturas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

            $vesture = Vesture::where('pieturas_id', $pietura->id)->orderByDesc('id')->first();
            if ($vesture) {
                $mp3Path = $vesture->mp3_path;
            } else {
                $mp3Path = null;
            }

            Vesture::create([
                'pieturas_id' => $pietura->id,
                'name' => $pietura->name,
                'text' => $pietura->text,
                'time' => time(), // Unix laiks
                'mp3_path' => $mp3Path,
            ]);
        });
    }

    public function getLatestMp3PathAttribute()
    {
        $latest = $this->vestures()
            ->whereNotNull('mp3_path')
            ->orderByDesc('time')
            ->first();

        return $latest?->mp3_path;
    }

    public function getLatestMp3UrlAttribute()
    {
        $latest = $this->vestures()
            ->whereNotNull('mp3_path')
            ->orderByDesc('time')
            ->first();

        if (!$latest) {
            return null;
        }

        return url("/secure-mp3/{$latest->id}");
    }
}
