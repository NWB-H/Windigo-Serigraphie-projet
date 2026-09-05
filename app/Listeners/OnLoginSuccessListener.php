<?php

namespace App\Listeners;

use App\Events\OnLoginSuccess;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OnLoginSuccessListener
{
    public function handle(OnLoginSuccess $event): void
    {
        try {
            $event->getUser()->update([
                'last_login_at' => now(),
            ]);
        } catch (\Throwable $th) {
            throw new BadRequestHttpException($th->getMessage());
        }
    }
}
