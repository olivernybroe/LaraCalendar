<?php


namespace Uruloke\LaraCalendar\Days;


use Carbon\Carbon;
use Uruloke\LaraCalendar\Contracts\Days\Day;

class Thursday implements Day
{

	public static function dayAsNumber (): int
	{
		return Carbon::THURSDAY;
	}
}