<?php


namespace Uruloke\LaraCalendar\Restrictions\Weekly;


use Uruloke\LaraCalendar\Carbon;
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

}