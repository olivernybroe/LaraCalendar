<?php

namespace Uruloke\LaraCalendar\Test\Daily;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Restrictions\Daily\WithoutDay;
use Uruloke\LaraCalendar\Test\TestCase;

class WithoutDayTest extends TestCase
{
    /** @test */
    public function can_remove_specific_day()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->startsAt(Carbon::parse('2017-09-05 08:00'));
        $builder->endsAt(Carbon::parse('2017-09-05 18:00'));
        $builder->allWeekDays();
        $builder->withoutDay(Carbon::parse('2017-09-07'));

        // Act
        $events = $builder->getNextEvents(3);

        // Assert
        $this->assertTrue($events->first()->startsAt()->isSameDay(Carbon::parse('2017-09-05')));
        $this->assertTrue($events->get(1)->startsAt()->isSameDay(Carbon::parse('2017-09-06')));
        $this->assertTrue($events->get(2)->startsAt()->isSameDay(Carbon::parse('2017-09-08')));
    }

    /** @test */
    public function can_convert_to_string()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->startsAt(Carbon::parse('2017-09-05 08:00'));
        $builder->endsAt(Carbon::parse('2017-09-05 18:00'));
        $builder->withoutDay(Carbon::parse('2017-09-07'));

        // Act
        $array = $builder->toArray();

        // Assert
        $this->assertContains('!d{2017-09-07}', $array);
    }

    /** @test */
    public function can_convert_from_string()
    {
        // Arrange
        $builder = EventBuilder::parse('!d{2017-08-08}');

        // Act
        $restrictions = $builder->getRestrictions();

        // Assert
        $this->assertCount(1, $restrictions);
        $this->assertContainsInstancesOf(WithoutDay::class, $restrictions);
    }
}
