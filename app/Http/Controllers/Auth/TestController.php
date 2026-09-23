<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;

final class TestController
{
    public function index()
    {
        return Inertia::render('Dev/Index');
    }
}
