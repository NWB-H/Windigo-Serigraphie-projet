<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\PaginatedResourceCollection;
use App\Models\User;
use Inertia\Inertia;

class UserController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Users',
            [
                'users' => fn () => new PaginatedResourceCollection(User::paginate(10)),
            ]
        );
    }
}
