<?php


namespace Uruloke\LaraCalendar\Restrictions\Weekly;


use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\Contracts\Restrictions\NeedToPass;
use Uruloke\LaraCalendar\EventCollection;

class NotWeekly extends Weekly implements NeedToPass
{
	public function passes (Carbon $currentDay, EventCollection $events): bool
	{
		return !parent::passes($currentDay, $events);
	}

	public function __toString (): string
	{
		return "!".parent::__toString();
	}


}