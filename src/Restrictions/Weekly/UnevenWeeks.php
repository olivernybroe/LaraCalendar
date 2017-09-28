<?php


namespace Uruloke\LaraCalendar\Restrictions\Weekly;


use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\EventCollection;

class UnevenWeeks extends Weekly
{
	public function passes (Carbon $currentDay, EventCollection $events): bool
	{
		if($currentDay->isUnevenWeek()) {
			return parent::passes($currentDay, $events);
		}
		return false;
	}

	public function __toString (): string
	{
		return "%%".parent::__toString();
	}


}