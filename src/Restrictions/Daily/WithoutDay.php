<?php

namespace Uruloke\LaraCalendar\Restrictions\Daily;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\EventCollection;
use Uruloke\LaraCalendar\Restrictions\CanParse;
use Uruloke\LaraCalendar\Contracts\Restrictions\Parseable;
use Uruloke\LaraCalendar\Contracts\Restrictions\NeedToPass;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;

class WithoutDay implements Restrictionable, NeedToPass, Parseable
{
    use CanParse;

    /** @var Carbon */
    public $withoutDay;

    /**
     * WithoutDay constructor.
     * @param $withoutDay
     */
    public function __construct(\DateTimeInterface $withoutDay)
    {
        $this->withoutDay = Carbon::parse($withoutDay);
    }

    public function passes(Carbon $currentDay, EventCollection $events): bool
    {
        return ! $currentDay->isSameDay($this->withoutDay);
    }

    /**
     * @return Restrictionable
     *
     * Parse in the parameters for converting from string to the
     * class.
     */
    public static function parse(): Restrictionable
    {
        $args = func_get_args();

        return new self(Carbon::parse($args[0]));
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [$this->withoutDay->toDateString()];
    }
}
