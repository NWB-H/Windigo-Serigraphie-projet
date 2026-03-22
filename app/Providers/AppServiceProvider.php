<?php

namespace App\Providers;

use App\Services\Notifications\Notification;
use App\Services\Notifications\NotificationType;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::macro('notification', function (string $message, NotificationType $type) {
            session()->push(
                'notifications',
                match ($type) {
                    NotificationType::SUCCESS => Notification::success($message),
                    NotificationType::ERROR => Notification::error($message),
                }
            );
        });
    }
}
