<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Resources\PaginatedResourceCollection;
use App\Models\User;
use App\Services\Notifications\NotificationType;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UserController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Users',
            [
                'users' => fn () => new PaginatedResourceCollection(User::where('role', '!=', RoleEnum::ROLE_ADMIN)->paginate(10)),
            ]
        );
    }

    public function unlock(User $user)
    {
        try {
            $user->update([
                'role' => RoleEnum::ROLE_USER,
            ]);

            return back();
        } catch (\Throwable $e) {
            Log::error('Impossible de débloquer un utilisateur', ['user' => $user->id, 'error' => $e->getMessage()]);
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }
    }

    public function lock(User $user)
    {
        try {
            $user->update([
                'role' => RoleEnum::ROLE_BLOCKED,
            ]);

            return back();
        } catch (\Throwable $e) {
            Log::error('Impossible de bloquer un utilisateur', ['user' => $user->id, 'error' => $e->getMessage()]);
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }
    }
}
