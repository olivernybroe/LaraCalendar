<?php


namespace Uruloke\LaraCalendar\Restrictions;


class RestrictionProvider
{
	public function getClass(string $name) {
		return config("calendar.maps.$name");
	}

	public function getClasses()
	{
		return config('calendar.maps');
	}

	public function getParsers()
	{
		return config('calendar.parser');
	}
}