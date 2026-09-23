<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\WorkshopSession
 */
final class WorkshopSessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'workshop_id' => $this->workshop_id,
            'session_number' => $this->session_number,
            'date' => $this->date->format('Y-m-d\TH:i'),
            'capacity' => $this->capacity,
            'remaining_places' => $this->remaining_places,
        ];
    }
}
