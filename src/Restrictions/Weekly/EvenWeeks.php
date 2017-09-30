<?php


namespace Uruloke\LaraCalendar\Restrictions\Weekly;


use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;
use Uruloke\LaraCalendar\EventCollection;

class EvenWeeks extends Weekly
{
	public function passes (Carbon $currentDay, EventCollection $events): bool
	{
		if($currentDay->isEvenWeek()) {
			return parent::passes($currentDay, $events);
		}
		return false;
	}

	public function __toString (): string
	{
		return "%".parent::__toString();
	}

	public static function parse (): Restrictionable
	{
		$args = func_get_args();
		return new EvenWeeks($args[0] ?? null);
	}


}