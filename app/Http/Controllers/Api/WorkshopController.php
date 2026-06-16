<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Workshop;

final class WorkshopController extends Controller
{
    public function delete(\Illuminate\Http\Request $request, Workshop $workshop)
    {
        try {
            $workshop->delete();

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}
