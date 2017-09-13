<?php

namespace Uruloke\LaraCalender\Test;

use Carbon\Carbon;
use EventCollection;
use Uruloke\LaraCalendar\Test\TestCase;

class EventCollectionTest extends TestCase
{

	/** @test */
	public function buildSimpleWeeklyRecurEvent ()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->title('02332 - Forelæsning');
		$builder->place('Building 306, DTU');
		$builder->description('Rum: 033');
		$builder->startsAt(Carbon::parse("5/9/2017 13:00"));
		$builder->endsAt(Carbon::parse("5/9/2017 15:00"));
		$builder->weekly(Tuesday::class);

		// Act
		$events = $builder->getNextEvents(5);

		// Assert
		$this->assertEquals($events->first()->startsAt(), Carbon::parse("5/9/2017 13:00"));
		$this->assertEquals($events->get(1)->startsAt(), Carbon::parse("12/9/2017 13:00"));
		$this->assertEquals($events->get(2)->startsAt(), Carbon::parse("19/9/2017 13:00"));
		$this->assertEquals($events->get(3)->startsAt(), Carbon::parse("26/9/2017 13:00"));
		$this->assertEquals($events->get(4)->startsAt(), Carbon::parse("3/10/2017 13:00"));
	}


}
