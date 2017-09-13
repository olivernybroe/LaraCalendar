<?php

namespace Uruloke\LaraCalender\Test;

use Carbon\Carbon;

use Uruloke\LaraCalendar\Days\{
	Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday
};
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Test\TestCase;

class WorkHoursTest extends TestCase
{
	/** @test */
	public function workFourWeeksEveryWeekShorthand()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->weekly([Monday::class, Tuesday::class, Wednesday::class, Thursday::class]);

		// Act
		$events = $builder->getNextEvents(5);
		// Assert
		$this->assertEquals(Carbon::parse("2017-09-05 08:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-06 08:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-07 08:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-11 08:00"), $events->get(3)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-12 08:00"), $events->get(4)->startsAt());
	}

	/** @test */
	public function workFourWeeksEveryWeek()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->weekly(Monday::class);
		$builder->andWeekly(Tuesday::class);
		$builder->andWeekly(Wednesday::class);
		$builder->andWeekly(Thursday::class);

		// Act
		$events = $builder->getNextEvents(5);

		// Assert
		$this->assertEquals(Carbon::parse("2017-09-05 08:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-06 08:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-07 08:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-11 08:00"), $events->get(3)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-12 08:00"), $events->get(4)->startsAt());
	}

	/** @test */
	public function workFourWeeksEveryWeekWithExclusion()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->allWorkdays();
		$builder->notWeekly(Friday::class);

		// Act
		$events = $builder->getNextEvents(5);

		// Assert
		$this->assertEquals(Carbon::parse("2017-09-05 08:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-06 08:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-07 08:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-11 08:00"), $events->get(3)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-12 08:00"), $events->get(4)->startsAt());
	}

	/** @test */
	public function workEverySecondSaturdayShorthand()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-09 10:00"));
		$builder->endsAt(Carbon::parse("2017-09-09 16:00"));
		$builder->biWeekly(Saturday::class);

		// Act
		$events = $builder->getNextEvents(5);

		// Assert
		$this->assertEquals(Carbon::parse("2017-09-09 10:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-23 10:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2017-10-07 10:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2017-10-21 10:00"), $events->get(3)->startsAt());
		$this->assertEquals(Carbon::parse("2017-11-04 10:00"), $events->get(4)->startsAt());
	}

	/** @test */
	public function workEverySecondSaturday()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-09 10:00"));
		$builder->endsAt(Carbon::parse("2017-09-09 16:00"));
		$builder->weekly(Saturday::class, 2);

		// Act
		$events = $builder->getNextEvents(5);

		// Assert
		$this->assertEquals(Carbon::parse("2017-09-09 10:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-23 10:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2017-10-07 10:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2017-10-21 10:00"), $events->get(3)->startsAt());
		$this->assertEquals(Carbon::parse("2017-11-04 10:00"), $events->get(4)->startsAt());
	}

	/** @test */
	public function workEveryEvenWeekOnSaturday()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-09 10:00"));
		$builder->endsAt(Carbon::parse("2017-09-09 16:00"));
		$builder->evenWeeks(Saturday::class);

		// Act
		$events = $builder->getNextEvents(5);

		// Assert
		$this->assertEquals(Carbon::parse("2017-09-09 10:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-23 10:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2017-10-07 10:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2017-10-21 10:00"), $events->get(3)->startsAt());
		$this->assertEquals(Carbon::parse("2017-11-04 10:00"), $events->get(4)->startsAt());
	}

	/** @test */
	public function workEveryUnevenWeekOnSaturday()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-09 10:00"));
		$builder->endsAt(Carbon::parse("2017-09-09 16:00"));
		$builder->unevenWeeks(Saturday::class);

		// Act
		$events = $builder->getNextEvents(5);

		// Assert
		$this->assertEquals(Carbon::parse("2017-09-16 10:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-30 10:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2017-10-14 10:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2017-10-28 10:00"), $events->get(3)->startsAt());
		$this->assertEquals(Carbon::parse("2017-11-11 10:00"), $events->get(4)->startsAt());
	}

	/** @test */
	public function canGetAllWorkingDaysBetweenTwoDaysWhereStartsAtIsAfterBetweenDays()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->weekly(Monday::class);

		// Act
		$events = $builder->getEventsBetween(Carbon::parse("2017-09-01"), Carbon::parse("2017-09-30"));

		// Assert
		$this->assertEquals(Carbon::parse("2017-09-04 08:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-11 08:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-18 08:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-25 08:00"), $events->get(3)->startsAt());
	}

	/** @test */
	public function canGetAllWorkingDaysBetweenTwoDaysWhereStartsAtIsBeforeBetweenDays()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->weekly(Monday::class);

		// Act
		$events = $builder->getEventsBetween(Carbon::parse("2017-09-15"), Carbon::parse("2017-09-30"));

		// Assert
		$this->assertEquals(Carbon::parse("2017-09-18 08:00"), $events->get(0)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-25 08:00"), $events->get(1)->startsAt());
	}

	/** @test */
	public function canGetEvensForMonth()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->weekly(Monday::class);

		// Act
		$events = $builder->getEventsForMonth("September");

		// Assert
		$this->assertEquals(Carbon::parse("2017-09-04 08:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-11 08:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-18 08:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2017-09-25 08:00"), $events->get(3)->startsAt());
	}

	/** @test */
	public function canGetEvensForMonthWithYear2018()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->weekly(Monday::class);

		// Act
		$events = $builder->getEventsForMonth("September", 2018);

		// Assert
		$this->assertEquals(Carbon::parse("2018-09-03 08:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2018-09-10 08:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2018-09-17 08:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2018-09-24 08:00"), $events->get(3)->startsAt());
	}

	/** @test */
	public function canGetEvensForMonthWithYear2010()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->weekly(Monday::class);

		// Act
		$events = $builder->getEventsForMonth("September", 2010);

		// Assert
		$this->assertEquals(Carbon::parse("2010-09-06 08:00"), $events->first()->startsAt());
		$this->assertEquals(Carbon::parse("2010-09-13 08:00"), $events->get(1)->startsAt());
		$this->assertEquals(Carbon::parse("2010-09-20 08:00"), $events->get(2)->startsAt());
		$this->assertEquals(Carbon::parse("2010-09-27 08:00"), $events->get(3)->startsAt());
	}
}
