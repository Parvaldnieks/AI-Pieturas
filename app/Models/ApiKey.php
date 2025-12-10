<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $table = 'api_atslegas';

    protected $fillable = ['key', 'device_name', 'api_pieprasijums_id'];

    public function request()
    {
        return $this->belongsTo(ApiRequest::class, 'api_pieprasijums_id');
    }
}
