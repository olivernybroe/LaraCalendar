<?php

namespace Uruloke\LaraCalendar\Restrictions;

use Uruloke\LaraCalendar\Days\Friday;
use Uruloke\LaraCalendar\Days\Monday;
use Uruloke\LaraCalendar\Days\Saturday;
use Uruloke\LaraCalendar\Days\Sunday;
use Uruloke\LaraCalendar\Days\Thursday;
use Uruloke\LaraCalendar\Days\Tuesday;
use Uruloke\LaraCalendar\Days\Wednesday;
use Uruloke\LaraCalendar\EventBuilder;

class Shortcuts
{
    public static function allWorkdays(EventBuilder $instance)
    {
        return $instance->weekly([
            Monday::class,
            Tuesday::class,
            Wednesday::class,
            Thursday::class,
            Friday::class,
        ]);
    }

    public static function allWeekDays(EventBuilder $instance)
    {
        $instance->allWeekendDays();

        return $instance->allWorkdays();
    }

    public static function allWeekendDays(EventBuilder $instance)
    {
        return $instance->weekly([
            Saturday::class,
            Sunday::class,
        ]);
    }
}
