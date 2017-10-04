<?php

namespace Uruloke\LaraCalendar\Contracts\Restrictions;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\EventCollection;

interface Restrictionable
{
    public function passes(Carbon $currentDay, EventCollection $events): bool;
}
