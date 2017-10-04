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

	public function startsAt() : Carbon
	{
		return $this->start;
	}

	public function endsAt() : Carbon
	{
		return $this->ends;
	}

	public static function getEventProperties() : array
	{
		if (property_exists(static::class, 'properties')) {
			return static::$properties;
		}

		return [];
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