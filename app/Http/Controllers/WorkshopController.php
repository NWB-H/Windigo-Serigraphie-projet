<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginatedResourceCollection;
use App\Models\Workshop;
use Inertia\Inertia;

class WorkshopController
{
    public function workshops()
    {
        return Inertia::render(
            'Workshops',
            [
                'workshops' => fn () => new PaginatedResourceCollection(Workshop::all()),
            ]
        );
    }

    public function workshop(Workshop $workshop)
    {
        return Inertia::render(
            'Workshop',
            [
                'workshop' => $workshop,
            ]
        );
    }
}
