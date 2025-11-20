<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valodas extends Model
{
    protected $table = 'valodas';

    protected $fillable = ['name', 'code',];

    public function tulkojumi()
    {
        return $this->hasMany(Tulkojums::class, 'valodas_id');
    }
}
