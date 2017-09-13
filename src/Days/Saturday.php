<?php


namespace Uruloke\LaraCalendar\Days;


use Carbon\Carbon;
use Uruloke\LaraCalendar\Contracts\Days\Day;

class Saturday implements Day
{

	public static function dayAsNumber (): int
	{
		return Carbon::SATURDAY;
	}
}