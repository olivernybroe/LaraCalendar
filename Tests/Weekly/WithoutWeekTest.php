<?php

namespace Uruloke\LaraCalendar\Test\Weekly;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Days\Monday;
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Test\TestCase;
use Uruloke\LaraCalendar\Restrictions\Weekly\WithoutWeek;

class WithoutWeekTest extends TestCase
{
    /** @test */
    public function can_convert_to_string()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->startsAt(Carbon::parse('2017-09-05 08:00'));
        $builder->endsAt(Carbon::parse('2017-09-05 18:00'));
        $builder->withoutWeek(37);

        // Act
        $array = $builder->toArray();

        // Assert
        $this->assertContains('!W{37}', $array);
    }

    /** @test */
    public function can_throw_error_when_week_is_too_high()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->startsAt(Carbon::parse('2017-09-05 08:00'));
        $builder->endsAt(Carbon::parse('2017-09-05 18:00'));

        // Act / Assert
        $this->expectException(\InvalidArgumentException::class);
        $builder->withoutWeek(53);
    }

    /** @test */
    public function can_throw_error_when_week_is_too_low()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->startsAt(Carbon::parse('2017-09-05 08:00'));
        $builder->endsAt(Carbon::parse('2017-09-05 18:00'));

        // Act / Assert
        $this->expectException(\InvalidArgumentException::class);
        $builder->withoutWeek(0);
    }

    /** @test */
    public function can_filter_week_out()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->startsAt(Carbon::parse('2017-09-05 08:00'));
        $builder->endsAt(Carbon::parse('2017-09-05 18:00'));
        $builder->withoutWeek(38);
        $builder->weekly(Monday::class);

        // Act
        $events = $builder->getNextEvents(2);

        // Assert
        $this->assertEquals(Carbon::parse('2017-09-11 08:00'), $events->first()->startsAt());
        $this->assertEquals(Carbon::parse('2017-09-25 08:00'), $events->get(1)->startsAt());
    }

    /** @test */
    public function can_convert_from_string()
    {
        // Arrange
        $builder = EventBuilder::parse('!W{1}');

        // Act
        $restrictions = $builder->getRestrictions();

        // Assert
        $this->assertCount(1, $restrictions);
        $this->assertContainsInstancesOf(WithoutWeek::class, $restrictions);
    }
}
