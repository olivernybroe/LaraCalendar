<?php

namespace Uruloke\LaraCalendar\Restrictions\Weekly;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Contracts\Restrictions\NeedToPass;
use Uruloke\LaraCalendar\Contracts\Restrictions\Parseable;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;
use Uruloke\LaraCalendar\EventCollection;
use Uruloke\LaraCalendar\Restrictions\CanParse;

class WithoutWeek implements Restrictionable, NeedToPass, Parseable
{
    use CanParse;

    /** @var int */
    protected $week;

    /**
     * WithoutWeek constructor.
     *
     * @param int $week
     */
    public function __construct(int $week)
    {
        throw_if(
            $week > Carbon::WEEKS_PER_YEAR || $week <= 0,
            \InvalidArgumentException::class,
            "Week [{$week}] is not a valid week for a year."
        );
        $this->week = $week;
    }

    public function passes(Carbon $currentDay, EventCollection $events): bool
    {
        return !$currentDay->isWeek($this->week);
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

        return new self($args[0]);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [$this->week];
    }
}
