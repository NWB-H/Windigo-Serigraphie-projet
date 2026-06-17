<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class OptionController
{
    public function delete(Request $request, Option $option)
    {
        try {
            $option->delete();

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de la suppression d'une option", ['error' => $e->getMessage(), 'option_id' => $option->id]);
            return response()->json($e->getMessage(), 400);
        }
    }
}
