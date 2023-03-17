<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityTripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'city_name' => $this->city->name,
            'arrival_time' => $this->arrival_time,
            'order' => $this->order,
            'city_id' => $this->city_id
        ];
    }
}
