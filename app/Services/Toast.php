<?php

namespace App\Services;

class Toast
{
    private function __construct(
        public string $message,
        public string $type,
    ) {
    }

    public static function success(string $message): self
    {
        return new static(
            $message,
            'success'
        );
    }

    public static function error(string $message): self
    {
        return new static(
            $message,
            'error'
        );
    }
}
