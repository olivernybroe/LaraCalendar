<?php


namespace Uruloke\LaraCalendar;


class Carbon extends \Illuminate\Support\Carbon
{
	public function isEvenWeek() : bool {
		return $this->weekOfYear % 2 == 0;
	}

	public function isUnevenWeek() : bool {
		return !$this->isEvenWeek();
	}
}