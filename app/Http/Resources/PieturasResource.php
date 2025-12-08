<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PieturasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'mp3_url' => $this->latest_mp3_url,
            'text'    => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
