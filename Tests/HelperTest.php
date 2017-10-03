<?php


namespace Uruloke\LaraCalendar\Test;


use Uruloke\LaraCalendar\Days\Monday;

class HelperTest extends TestCase
{
    /** @test */
    public function can_convert_integer_to_day()
    {
        // Act
        $day = int_to_day(1);

        // Assert
        $this->assertEquals(Monday::class, $day);
    }

    /** @test */
    public function cannot_convert_integer_to_day_when_invalid_day()
    {
        // Act / Assert
        $day = int_to_day(10);

        // Assert
        $this->assertEquals(null, $day);
    }
}