<?php

namespace App\Services\Notifications;

enum NotificationType: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
}
