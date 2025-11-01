<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;

class InformationController extends Controller
{
    public function about()
    {
        return Inertia::render('About');
    }

    public function portfolio()
    {
        return Inertia::render('Portfolio');
    }
}
