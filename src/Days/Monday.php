<?php


namespace Uruloke\LaraCalendar\Days;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Contracts\Days\Day;

class Monday implements Day
{

	public static function dayAsNumber () : int

	{
		return Carbon::MONDAY;
	}
}