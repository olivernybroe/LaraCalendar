<?php


namespace Uruloke\LaraCalendar\Days;


use Carbon\Carbon;
use Uruloke\LaraCalendar\Contracts\Days\Day;

class Monday implements Day
{

	public static function dayAsNumber () : int

	{
		return Carbon::MONDAY;
	}
}