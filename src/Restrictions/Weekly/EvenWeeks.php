<?php

namespace Uruloke\LaraCalendar\Restrictions\Weekly;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\EventCollection;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;

class EvenWeeks extends Weekly
{
    public function passes(Carbon $currentDay, EventCollection $events): bool
    {
        if ($currentDay->isEvenWeek()) {
            return parent::passes($currentDay, $events);
        }

        return false;
    }

    public static function parse(): Restrictionable
    {
        $args = func_get_args();

        return new self($args[0] ?? null);
    }
}
