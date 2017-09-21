<?php


namespace Uruloke\LaraCalendar\Models;


use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateInterval;
use DateTimeInterface;
use Uruloke\LaraCalendar\Contracts\Eventable;

/**
 * Class Event
 * @property Carbon start
 * @package Uruloke\LaraCalendar\Models
 */
class Event implements Eventable
{
	use HasEvent;
}