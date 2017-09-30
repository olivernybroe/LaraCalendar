<?php


namespace Uruloke\LaraCalendar\Restrictions\Daily;


use Carbon\Carbon;
use Illuminate\Support\Str;
use Uruloke\LaraCalendar\Contracts\Restrictions\NeedToPass;
use Uruloke\LaraCalendar\Contracts\Restrictions\Parseable;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;
use Uruloke\LaraCalendar\EventCollection;
use \Uruloke\LaraCalendar\Carbon AS laraCarbon;

class WithoutDay implements Restrictionable, NeedToPass, Parseable
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

	public function __toString (): string
	{
		return "!d{{$this->withoutDay->toDateString()}}";
	}

	/**
	 * @return Restrictionable
	 *
	 * Parse in the parameters for converting from string to the
	 * class.
	 */
	public static function parse (): Restrictionable
	{
		$args = func_get_args();

		return new WithoutDay(Carbon::parse($args[0]));
	}
}