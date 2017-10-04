<?php


namespace Uruloke\LaraCalendar\Test\Weekly;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Days\Monday;
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Restrictions\Weekly\NotWeekly;
use Uruloke\LaraCalendar\Test\TestCase;

class NotWeeklyTest extends TestCase
{
	/** @test */
	public function can_convert_to_string()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->notWeekly(Monday::class);

		// Act
		$array = $builder->toArray();
		// Assert
		$this->assertContains("!w{1,0}", $array);
	}

	/** @test */
	public function can_convert_to_string_when_n_weekly()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->notWeekly(Monday::class, 77);

		// Act
		$array = $builder->toArray();

		// Assert
		$this->assertContains("!w{1,77}", $array);
	}

	/** @test */
	public function can_convert_from_string()
	{
		// Arrange
		$builder = EventBuilder::parse("!w{1}");

		// Act
		$restrictions = $builder->getRestrictions();

		// Assert
		$this->assertCount(1, $restrictions);
		$this->assertContainsInstancesOf(NotWeekly::class, $restrictions);
	}

	/** @test */
	public function can_convert_from_string_when_n_weekly()
	{
		// Arrange
		$builder = EventBuilder::parse("!w{1,43}");

		// Act
		$restrictions = $builder->getRestrictions();

		// Assert
		$this->assertCount(1, $restrictions);
		$this->assertContainsInstancesOf(NotWeekly::class, $restrictions);
	}
}