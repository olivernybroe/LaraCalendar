<?php


namespace Uruloke\LaraCalendar\Contracts\Restrictions;


use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\EventCollection;

interface Restrictionable
{
	public function passes(Carbon $currentDay, EventCollection $events): bool;
}