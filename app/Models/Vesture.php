<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pieturas;

class Vesture extends Model
{
    protected $table = 'vesture';

    protected $fillable = [
        'pieturas_id',
        'mp3_path',
        'name',
        'text',
        'time',
    ];

    public function pietura()
    {
        return $this->belongsTo(Pieturas::class);
    }
}
