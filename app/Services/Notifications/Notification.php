<?php

namespace App\Services\Notifications;

class Notification
{
    public function __construct(
        public string $message,
        public NotificationType $type
    ) {}

    public static function success(string $message): self
    {
        return new static(
            $message,
            NotificationType::SUCCESS
        );
    }

    public static function error(string $message): self
    {
        return new static(
            $message,
            NotificationType::ERROR
        );
    }
}
