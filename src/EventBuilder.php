<?php

namespace Uruloke\LaraCalendar;

use Illuminate\Support\Str;
use Uruloke\LaraCalendar\Contracts\Restrictions\NeedToPass;
use Uruloke\LaraCalendar\Contracts\Restrictions\Restrictionable;
use Uruloke\LaraCalendar\Days\{
	Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday
};
use Uruloke\LaraCalendar\Models\Event;
use Uruloke\LaraCalendar\Restrictions\RestrictionCollection;
use Uruloke\LaraCalendar\Restrictions\RestrictionProvider;

/**
 * Class EventBuilder
 * @method $this biWeekly(string|array $days)
 * @method $this weekly(string|array $days, int $everyNWeek = null)
 * @method $this andWeekly(string|array $days, int $everyNWeek = null)
 * @method $this notWeekly(string|array $days, int $everyNWeek = null)
 * @method $this evenWeeks(string|array $days)
 * @method $this unevenWeeks(string|array $days)
 * @package Uruloke\LaraCalendar
 */
class EventBuilder
{
	/** @var  Carbon */
	protected $startsAt;
	/** @var  Carbon */
	protected $endsAt;

	/** @var RestrictionCollection  */
	protected $restrictions;


	/**
	 * EventBuilder constructor.
	 */
	public function __construct ()
	{
		$this->restrictions = new RestrictionCollection();
	}


	public function startsAt(\DateTimeInterface $startsAt)
	{
		$this->startsAt = Carbon::parse($startsAt);
		return $this;
	}

	public function endsAt(\DateTimeInterface $endsAt)
	{
		$this->endsAt = Carbon::parse($endsAt);
		return $this;
	}

	public function allWorkdays()
	{
		return $this->weekly([
			Monday::class,
			Tuesday::class,
			Wednesday::class,
			Thursday::class,
			Friday::class
		]);
	}

	public function allWeekendDays()
	{
		return $this->weekly([
			Saturday::class,
			Sunday::class
		]);
	}

	public function allWeekDays()
	{
		$this->allWeekendDays();
		return $this->allWorkdays();
	}

	public function getEventsBetween(\DateTimeInterface $from, \DateTimeInterface $to) : EventCollection
	{
		$events = new EventCollection();
		$from = Carbon::parse($from);
		$to = Carbon::parse($to);
		$currentDay = $this->startsAt->setDate($from->year, $from->month, $from->day);
		$currentEndDay = $this->endsAt->setDate($from->year, $from->month, $from->day);

		while ($from->lessThanOrEqualTo($to)) {
			if(!$this->isDayValid($from, $events)) {
				$from = $from->addDay();
				$currentDay = $currentDay->addDay();
				$currentEndDay = $currentEndDay->addDay();
				continue;
			}

			$event = new Event(clone $currentDay, clone $currentEndDay);
			$events->push($event);

			$from->addDay();
			$currentDay = $currentDay->addDay();
			$currentEndDay = $currentEndDay->addDay();
		}

		return $events;
	}

	public function getEventsForMonth($month, $year = null) : EventCollection
	{
		$day = Carbon::parse("$month $year")->day(1);
		return $this->getEventsBetween(clone $day->startOfMonth(), $day->endOfMonth());
	}

	public function getNextEvents(int $amount)
	{
		$events = new EventCollection();

		$currentDay = $this->startsAt;
		$currentEndDay = $this->endsAt;

		while ($events->count() <= $amount){
			if(!$this->isDayValid($currentDay, $events)) {
				$currentDay = $currentDay->addDay();
				$currentEndDay = $currentEndDay->addDay();
				continue;
			}

			$event = new Event(clone $currentDay, clone $currentEndDay);

			$events->push($event);

			$currentDay = $currentDay->addDay();
			$currentEndDay = $currentEndDay->addDay();
		}

		return $events;
	}

	public function __call ($name, $arguments)
	{
		if(sizeof($arguments) >= 1) {
			$days = collect($arguments[0]);
			unset($arguments[0]);

			$this->removeAndFromCall($name);

			$className = app(RestrictionProvider::class)->getClass($name);
			throw_unless(class_exists($className), \InvalidArgumentException::class, "Class [{$name}] does not exist in config.");

			$days->each(function($day) use ($name, $className, $arguments) {
				$this->restrictions->push(new $className($day, ...$arguments));
			});

			return $this;
		}
		throw new \InvalidArgumentException("Missing arguments...");
	}


	private function removeAndFromCall (&$name)
	{
		if (Str::startsWith($name, 'and')) {
			$name = Str::after($name, 'and');
			$name = Str::snake($name);
		}
	}

	private function isDayValid (Carbon $currentDay, EventCollection $events): bool
	{
		$passes = false;
		$needToPass = true;

		$this->restrictions->each(function (Restrictionable $restriction) use (&$passes, &$needToPass, $currentDay, $events) {
			if ($restriction instanceof NeedToPass) {
				$needToPass = $restriction->passes($currentDay, $events);
			} else {
				if ($restriction->passes($currentDay, $events)) {
					$passes = true;
				}
			}
		});
		return $passes && $needToPass;
	}

}