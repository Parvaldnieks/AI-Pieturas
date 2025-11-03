<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mp3 extends Model
{
    protected $table = 'mp3_voices';
    
    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];
}
