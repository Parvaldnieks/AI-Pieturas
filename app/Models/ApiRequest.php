<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiRequest extends Model
{ 
    protected $fillable = ['device_type', 'device_os', 'email', 'note', 'status', 'blocked'];
    
    public function apiKey()
    {
        return $this->hasOne(ApiKey::class);
    }

    public function isBlocked()
    {
        return $this->blocked;
    }
}
