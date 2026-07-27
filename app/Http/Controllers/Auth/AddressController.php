<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Form\AddressFormRequest;
use App\Models\Address;
use App\Services\Notifications\NotificationType;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AddressController
{
    public function store(AddressFormRequest $request)
    {
        $validated = $request->validated();

        try {
            Address::updateOrCreate(
                ['id' => $validated['id'] ?? null],
                $validated,
            );

            Inertia::notification('Adresse enregistré', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de l'enregistrement de l'addresse", ['erreur' => $e->getMessage()]);
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }

        return back();
    }
}
