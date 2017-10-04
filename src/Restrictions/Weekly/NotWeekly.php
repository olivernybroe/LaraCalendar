<?php

namespace Uruloke\LaraCalendar\Restrictions\Weekly;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Contracts\Restrictions\NeedToPass;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;
use Uruloke\LaraCalendar\EventCollection;

class NotWeekly extends Weekly implements NeedToPass
{
    public function passes(Carbon $currentDay, EventCollection $events): bool
    {
        return !parent::passes($currentDay, $events);
    }

    public static function parse(): Restrictionable
    {
        $args = func_get_args();

        return new self(int_to_day($args[0]), $args[1] ?? null);
    }
}
