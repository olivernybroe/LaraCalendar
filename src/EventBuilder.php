<?php

namespace Uruloke\LaraCalendar;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Uruloke\LaraCalendar\Contracts\Eventable;
use Uruloke\LaraCalendar\Contracts\Restrictions\NeedToPass;
use Uruloke\LaraCalendar\Contracts\Restrictions\Parseable;
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
 * @method $this withoutDay(Carbon|array $days)
 * @method $this withoutWeek(int $weekNumber)
 * @method $this allWorkdays()
 * @method $this allWeekDays()
 * @package Uruloke\LaraCalendar
 */
class EventBuilder implements Arrayable
{
	use Macroable {
		Macroable::__call as macroCall;
	}

	/** @var  Carbon */
	protected $startsAt;
	/** @var  Carbon */
	protected $endsAt;

	/** @var RestrictionCollection  */
	protected $restrictions;

	/** @var Eventable */
	protected $eventType;

	/** @var array */
	protected $eventValues = [];

	public static $days = [
		Monday::class,
		Tuesday::class,
		Wednesday::class,
		Thursday::class,
		Friday::class,
		Saturday::class,
		Sunday::class
	];

	/**
	 * EventBuilder constructor.
	 */
	public function __construct ()
	{
		$this->restrictions = new RestrictionCollection();
		$this->eventType = config('calendar.drivers.event', Event::class);
	}

	public static function parse(string $parse) : EventBuilder
	{
		$builder = new EventBuilder();

		$parser = explode('|', $parse);

		foreach (app(RestrictionProvider::class)->getParsers() as $parseRegex => $parserClass) {
			foreach ($parser as $parse) {
				if(preg_match("/^{$parseRegex}/", $parse, $matches)) {
					unset($matches[0]);
					$builder->restrictions->push($parserClass::parse(...$matches));
				}
			}
		}
		return $builder;
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

	/**
	 * @param $currentDay
	 * @param $currentEndDay
	 * @param $events
	 */
	private function collectEvent($currentDay, $currentEndDay, $events) : void
	{
		$event = $this->createEvent($currentDay, $currentEndDay);
		$events->push($event);
	}

	/**
	 * @param array ...$dates
	 */
	private function increaseByDay(...$dates) : void
	{
		foreach ($dates as $date) {
			$date->addDay();
		}
	}

	/**
	 * @param \DateTimeInterface $from
	 * @param \DateTimeInterface $to
	 *
	 * @return EventCollection
	 */
	public function getEventsBetween(\DateTimeInterface $from, \DateTimeInterface $to) : EventCollection
	{
		$events = new EventCollection();
		$from = Carbon::parse($from);
		$to = Carbon::parse($to);
		$currentDay = $this->startsAt->setDate($from->year, $from->month, $from->day);
		$currentEndDay = $this->endsAt->setDate($from->year, $from->month, $from->day);

		while ($from->lessThanOrEqualTo($to)) {
			if(!$this->isDayValid($from, $events)) {
				$this->increaseByDay($from, $currentDay, $currentEndDay);
				continue;
			}

			$this->collectEvent($currentDay, $currentEndDay, $events);
			$this->increaseByDay($from, $currentDay, $currentEndDay);
		}

		return $events;
	}

	public function getEventsForMonth($month, $year = null) : EventCollection
	{
		$day = Carbon::parse("$month $year")->day(1);
		return $this->getEventsBetween(clone $day->startOfMonth(), $day->endOfMonth());
	}

	public function getNextEvent() {
		return $this->getNextEvents(1)->first();
	}

	/**
	 * @param int $amount
	 *
	 * @return EventCollection
	 */
	public function getNextEvents(int $amount)
	{
		$events = new EventCollection();

		$currentDay = $this->startsAt;
		$currentEndDay = $this->endsAt;

		while ($events->count() <= $amount) {
			if(!$this->isDayValid($currentDay, $events)) {
				$this->increaseByDay($currentDay, $currentEndDay);
				continue;
			}

			$this->collectEvent($currentDay, $currentEndDay, $events);
			$this->increaseByDay($currentDay, $currentEndDay);
		}

		return $events;
	}

	public function __call ($name, $arguments)
	{
		if($this->isEventProperty($name)) {
			return $this->callEventProperty($name, $arguments);
		}
		$this->removeAndFromCall($name);
		return $this->macroCall($name, $arguments);
	}

	public function toString()
	{
		return implode("|", $this->toArray());
	}

	public function toArray()
	{
		$restrictions = [
			"^{{$this->startsAt->timestamp}}",
			"\${{$this->endsAt->timestamp}}",
		];
		return $this->restrictions->map(function(Parseable $restriction) {
			return $restriction->__toString();
		})->merge($restrictions)->toArray();
	}

	public function __toString ()
	{
		return $this->toString();
	}

	public function isEventProperty($name) {
		return $this->eventType::hasEventProperty($name);
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

	/**
	 * @param string $eventType
	 * @return EventBuilder
	 */
	public function setEvent ($eventType)
	{
	    throw_unless(array_has(class_implements($eventType), Eventable::class), \InvalidArgumentException::class, "The given event [{$eventType}] does not implement [Eventable]");
		$this->eventType = $eventType;
		return $this;
	}

	/**
	 * @param $currentDay
	 * @param $currentEndDay
	 * @return mixed
	 */
	private function createEvent ($currentDay, $currentEndDay)
	{
		/** @var Eventable $event */
		$event = new $this->eventType();
		$event->setStart($currentDay);
		$event->setEnds($currentEndDay);

		foreach ($this->eventValues as $key => $value){
			$event->$key = $value;
		}

		return $event;
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return $this|mixed
	 */
	private function callEventProperty ($name, $arguments)
	{
		if (sizeof($arguments) >= 1) {
			$this->eventValues[$name] = $arguments[0];
			return $this;
		}
		return $this->eventValues[$name];
	}

	/**
	 * @return RestrictionCollection
	 */
	public function getRestrictions (): RestrictionCollection
	{
		return $this->restrictions;
	}

}