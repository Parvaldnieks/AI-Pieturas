<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vesture;

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
            Vesture::create([
                'pieturas_id' => $pietura->id,
                'text' => $pietura->text,
                'time' => time(), // Unix laiks
            ]);
        });

        static::updated(function ($pietura) {
            Vesture::create([
                'pieturas_id' => $pietura->id,
                'text' => $pietura->text,
                'time' => time(), // Unix laiks
            ]);
        });
    }
}
