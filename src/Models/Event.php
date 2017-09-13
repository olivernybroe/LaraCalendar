<?php


namespace Uruloke\LaraCalendar\Models;


use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateInterval;
use DateTimeInterface;

class Event
{
	protected $start;

	protected $end;

	/**
	 * Event constructor.
	 * @param Carbon $start
	 * @param Carbon $end
	 */
	public function __construct (Carbon $start, Carbon $end)
	{
		$this->start =  $start;
		$this->end = $end;
	}

	public function startsAt()
	{
		return $this->start;
	}

}