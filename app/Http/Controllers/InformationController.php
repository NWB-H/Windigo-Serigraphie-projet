<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;

class InformationController
{
    public function about()
    {
        return Inertia::render('About');
    }

    public function portfolio()
    {
        return Inertia::render('Portfolio');
    }

    public function confidentialite()
    {
        return Inertia::render('Confidentialite');
    }

    public function mentions()
    {
        return Inertia::render('Mentions');
    }
}
