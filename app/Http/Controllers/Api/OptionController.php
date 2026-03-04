<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Option;
use Illuminate\Http\Request;

final class OptionController
{
    public function delete(Request $request, Option $option)
    {
        try {
            $option->delete();
            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}