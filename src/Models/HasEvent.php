<?php


namespace Uruloke\LaraCalendar\Models;

use Uruloke\LaraCalendar\Carbon;


/**
 * Trait HasEvent
 * @package Uruloke\LaraCalendar\Models
 */
trait HasEvent
{
	protected $start;

	protected $ends;

	public function startsAt()
	{
		return $this->start;
	}

	public function endsAt()
	{
		return $this->ends;
	}

	public static function getEventProperties() : array
	{
		return static::$properties ?? [];
	}

	public static function hasEventProperty(string $key) : bool
	{
		return collect(static::getEventProperties())->contains($key);
	}

	public function setStart (\DateTimeInterface $start)
	{
		$this->start = Carbon::parse($start);
		return $this;
	}

	public function setEnds (\DateTimeInterface $ends)
	{
		$this->ends = Carbon::parse($ends);
		return $this;
	}
}