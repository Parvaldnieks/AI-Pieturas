<?php

namespace App\Models;

use App\Models\Pieturas;
use Illuminate\Database\Eloquent\Model;

class Vesture extends Model
{
    protected $table = 'vesture';
    protected $appends = ['secure_url'];

    protected $fillable = [
        'pieturas_id',
        'mp3_path',
        'name',
        'text',
        'time',
    ];

    public function pietura()
    {
        return $this->belongsTo(Pieturas::class, 'pieturas_id');
    }

    public function getSecureUrlAttribute()
    {
        return url("/secure-mp3/{$this->id}");
    }
}
