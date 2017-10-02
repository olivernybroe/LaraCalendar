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

	public function getParserFromClass(string $class)
	{
		return array_search($class,$this->getParsers());
	}

	public function getShortcuts()
	{
		return config('calendar.shortcuts');
	}
}