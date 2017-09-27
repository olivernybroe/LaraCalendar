<?php


namespace Uruloke\LaraCalendar\Restrictions;


class RestrictionProvider
{
	public function getClass(string $name) {
		return config("calendar.maps.$name");
	}

}