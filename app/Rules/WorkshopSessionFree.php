<?php

namespace App\Rules;

use App\Models\Workshop;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;
use Illuminate\Translation\PotentiallyTranslatedString;

final class WorkshopSessionFree implements ValidationRule
{
    public function __construct(private readonly Workshop $workshop) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $startsAt = Carbon::parse($value);
        $endsAt = $startsAt->copy()->addMinutes($this->workshop->duration);

        $overlapsExistingSession = $this->workshop
            ->workshopSessions()
            ->where('date', '<=', $endsAt)
            ->where('date', '>=', $startsAt)
            ->exists();

        if ($overlapsExistingSession) {
            $fail('Une session est déjà planifiée sur ce créneau.');
        }
    }
}
