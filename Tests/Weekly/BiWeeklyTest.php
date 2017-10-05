<?php

namespace Uruloke\LaraCalendar\Test\Weekly;

use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Days\Monday;
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Test\TestCase;
use Uruloke\LaraCalendar\Restrictions\Weekly\Weekly;

class BiWeeklyTest extends TestCase
{
    /** @test */
    public function can_convert_to_string()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->startsAt(Carbon::parse('2017-09-05 08:00'));
        $builder->endsAt(Carbon::parse('2017-09-05 18:00'));
        $builder->biWeekly(Monday::class);

        // Act
        $array = $builder->toArray();

        // Assert
        $this->assertContains('w{1,2}', $array);
    }

    /** @test */
    public function can_convert_from_string()
    {
        // Arrange
        $builder = EventBuilder::parse('w{1,2}');

        // Act
        $restrictions = $builder->getRestrictions();

        // Assert
        $this->assertCount(1, $restrictions);
        $this->assertContainsInstancesOf(Weekly::class, $restrictions);
    }
}
