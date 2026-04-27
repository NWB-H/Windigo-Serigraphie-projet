<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Resources\PaginatedResourceCollection;
use App\Models\Workshop;
use Inertia\Inertia;

final class WorkshopController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Workshops',
            [
                'workshops' => fn () => new PaginatedResourceCollection(Workshop::paginate(20)),
            ],
        );
    }
}
