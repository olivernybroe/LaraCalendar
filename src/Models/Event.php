<?php

namespace Uruloke\LaraCalendar\Models;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Contracts\Eventable;

/**
 * Class Event.
 * @property Carbon start
 */
class Event implements Eventable
{
    use HasEvent;
}
