<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class PendingKey extends Model
{
    protected $table = 'gaidosas_atslegas';

    protected $fillable = ['email', 'api_key', 'copied', 'expires_at'];

    protected $dates = ['expires_at'];

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->lt(now());
    }
}
