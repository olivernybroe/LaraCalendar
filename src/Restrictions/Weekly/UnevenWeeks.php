<?php


namespace Uruloke\LaraCalendar\Restrictions\Weekly;


use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;
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

	public static function parse (): Restrictionable
	{
		$args = func_get_args();
		return new UnevenWeeks($args[0] ?? null);
	}
}