<?php


namespace Uruloke\LaraCalendar\Test;


use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Restrictions\Daily\WithoutDay;
use Uruloke\LaraCalendar\Restrictions\Weekly\NotWeekly;
use Uruloke\LaraCalendar\Restrictions\Weekly\Weekly;

class StringifyTest extends TestCase
{
	/** @test */
	public function can_convert_to_string()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt($start = Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt($end = Carbon::parse("2017-09-05 18:00"));
		$builder->allWeekDays();
		$builder->withoutDay(Carbon::parse("2017-09-07"));

		// Act
		$string = $builder->toString();

		// Assert
		$this->assertStringContains("^{{$start->timestamp}}", $string);
		$this->assertStringContains("\${{$end->timestamp}}", $string);
		$this->assertStringContains("w{0,0}", $string); // Has monday.
		$this->assertStringContains("!d{2017-09-07}", $string); // Without specific day.
	}

	/** @test */
	public function can_convert_to_builder()
	{
		// Arrange
		$builder = EventBuilder::parse("^{1504598400}|\${1504634400}|w{1}|!d{2017-09-07}");


		// Act
		$restrictions = $builder->getRestrictions();

		// Assert
		$this->assertCount(2, $restrictions);
		$this->assertContainsInstancesOf(Weekly::class, $restrictions);
		$this->assertContainsInstancesOf(WithoutDay::class, $restrictions);


	}

}