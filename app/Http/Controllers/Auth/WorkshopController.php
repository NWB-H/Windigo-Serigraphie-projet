<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\Workshop;
use Inertia\Inertia;

final class WorkshopController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Workshops',
            [
                'workshops' => Workshop::all(),
            ],
        );
    }
}