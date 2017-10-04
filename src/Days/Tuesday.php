<?php


namespace Uruloke\LaraCalendar\Days;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Contracts\Days\Day;

class Tuesday implements Day
{

	public static function dayAsNumber (): int
	{
		return Carbon::TUESDAY;
	}
}