<?php


namespace Uruloke\LaraCalendar\Days;


use Carbon\Carbon;
use Uruloke\LaraCalendar\Contracts\Days\Day;

class Friday implements Day
{

	public static function dayAsNumber () : int
	{
		return Carbon::FRIDAY;
	}
}