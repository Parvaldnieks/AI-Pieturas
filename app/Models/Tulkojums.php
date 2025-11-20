<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tulkojums extends Model
{
    protected $table = 'tulkojums';

    protected $fillable = ['originals_id', 'valodas_id', 'translation',];

    public function original()
    {
        return $this->belongsTo(Originals::class, 'originals_id');
    }

    public function valoda()
    {
        return $this->belongsTo(Valodas::class, 'valodas_id');
    }
}
