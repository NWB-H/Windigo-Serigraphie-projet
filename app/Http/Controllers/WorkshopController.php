<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Inertia\Inertia;

class WorkshopController
{
    public function workshops()
    {
        return Inertia::render(
            'Workshops',
            [
                'workshops' => Workshop::all(),
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
