<?php


namespace Uruloke\LaraCalendar\Contracts;


interface Eventable
{
	public function startsAt();

	public function endsAt();

	public static function getEventProperties() : array;

	public static function hasEventProperty(string $key) : bool;

	public function setEnds (\DateTimeInterface $ends);

	public function setStart (\DateTimeInterface $start);
}