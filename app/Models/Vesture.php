<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pieturas;

class Vesture extends Model
{
    protected $table = 'vesture';

    protected $fillable = [
        'time',
        'text',
        //'file_name',
        'pieturas_id',
    ];

    public function pietura()
    {
        return $this->belongsTo(Pieturas::class);
    }
}
