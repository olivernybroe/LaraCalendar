<?php


namespace Uruloke\LaraCalendar\Restrictions\Daily;


use Carbon\Carbon;
use Uruloke\LaraCalendar\Contracts\Restrictions\NeedToPass;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;
use Uruloke\LaraCalendar\EventCollection;
use \Uruloke\LaraCalendar\Carbon AS laraCarbon;

class WithoutDay implements Restrictionable, NeedToPass
{
	/** @var Carbon */
	public $withoutDay;

	/**
	 * WithoutDay constructor.
	 * @param $withoutDay
	 */
	public function __construct (\DateTimeInterface $withoutDay)
	{
		$this->withoutDay = Carbon::parse($withoutDay);
	}


	public function passes (laraCarbon $currentDay, EventCollection $events): bool
	{
		return !$currentDay->isSameDay($this->withoutDay);
	}
}