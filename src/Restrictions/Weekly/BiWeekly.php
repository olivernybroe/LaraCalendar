<?php


namespace Uruloke\LaraCalendar\Restrictions\Weekly;

class BiWeekly extends Weekly
{
	public function __construct ($day)
	{
		parent::__construct($day, 2);
	}

}