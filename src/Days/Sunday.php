<?php


namespace Uruloke\LaraCalendar\Days;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Contracts\Days\Day;

class Sunday implements Day
{

	public static function dayAsNumber (): int
	{
		return Carbon::SUNDAY;
	}
}