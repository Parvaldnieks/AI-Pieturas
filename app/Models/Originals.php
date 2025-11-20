<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Originals extends Model
{
    protected $table = 'originals';

    protected $fillable = ['key', 'text',];

    public function tulkojumi()
    {
        return $this->hasMany(Tulkojums::class, 'originals_id');
    }
}
