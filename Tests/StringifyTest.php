<?php


namespace Uruloke\LaraCalendar\Test;


use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\EventBuilder;

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
		$this->assertStringContains("w{0}", $string); // Has monday.
		$this->assertStringContains("!d{2017-09-07}", $string); // Without specific day.
	}

	public function can_convert_to_builder()
	{
		// Arrange
		$builder = new EventBuilder("^{1504598400}|\${1504634400}|w{6}|w{0}|w{1}|w{2}|w{3}|w{4}|w{5}|!d{2017-09-07}");


		// Act

		// Assert


	}

}