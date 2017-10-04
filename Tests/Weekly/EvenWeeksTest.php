<?php

namespace Uruloke\LaraCalendar\Test\Weekly;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Days\Monday;
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Restrictions\Weekly\EvenWeeks;
use Uruloke\LaraCalendar\Test\TestCase;

class EvenWeeksTest extends TestCase
{
    /** @test */
    public function can_convert_to_string()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->startsAt(Carbon::parse('2017-09-05 08:00'));
        $builder->endsAt(Carbon::parse('2017-09-05 18:00'));
        $builder->evenWeeks(Monday::class);

        // Act
        $array = $builder->toArray();

        // Assert
        $this->assertContains('%w{1}', $array);
    }

    /** @test */
    public function can_convert_from_string()
    {
        // Arrange
        $builder = EventBuilder::parse('%w{1}');

        // Act
        $restrictions = $builder->getRestrictions();

        // Assert
        $this->assertCount(1, $restrictions);
        $this->assertContainsInstancesOf(EvenWeeks::class, $restrictions);
    }
}
