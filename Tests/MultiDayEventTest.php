<?php


namespace Uruloke\LaraCalendar\Test;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\EventBuilder;

class MultiDayEventTest extends TestCase
{
    /** @test */
    public function can_create_event_over_multiple_days()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->startsAt(Carbon::parse("2017-09-05 08:00"));
        $builder->endsAt(Carbon::parse("2017-09-06 08:00"));
        $builder->allWeekDays();

        // Act
        $events =$builder->getNextEvents(5);

        // Assert
       $this->assertEventDays($events->first(), "2017-09-05 08:00", "2017-09-06 08:00");
       $this->assertEventDays($events->get(1), "2017-09-06 08:00", "2017-09-07 08:00");
       $this->assertEventDays($events->get(2), "2017-09-07 08:00", "2017-09-08 08:00");
       $this->assertEventDays($events->get(3), "2017-09-08 08:00", "2017-09-09 08:00");
       $this->assertEventDays($events->get(4), "2017-09-09 08:00", "2017-09-10 08:00");
    }

}