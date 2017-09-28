<?php


namespace Uruloke\LaraCalendar\Restrictions\Weekly;


use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\Contracts\Restrictions\NeedToPass;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;
use Uruloke\LaraCalendar\EventCollection;

class WithoutWeek implements Restrictionable, NeedToPass
{
	/** @var int */
	protected $week;

	/**
	 * WithoutWeek constructor.
	 * @param int $week
	 */
	public function __construct (int $week)
	{
		throw_if(
			$week > Carbon::WEEKS_PER_YEAR || $week <= 0,
			\InvalidArgumentException::class,
			"Week [{$week}] is not a valid week for a year."
		);
		$this->week = $week;
	}


	public function passes (Carbon $currentDay, EventCollection $events): bool
	{
		return !$currentDay->isWeek($this->week);
	}

	public function __toString (): string
	{
		return "!W{{$this->week}}";
	}
}