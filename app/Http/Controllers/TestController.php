<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\Controller;
use Inertia\Inertia;

class TestController extends Controller
{
    public function alexis()
    {
        return Inertia::render('Test/Alexis', [
            'userName' => 'alexis'
        ]);
    }
}
