<?php


namespace Uruloke\LaraCalendar\Test;


use Uruloke\LaraCalendar\Restrictions\RestrictionProvider;
use Uruloke\LaraCalendar\Restrictions\Weekly\Weekly;

class RestrictionProviderTest extends TestCase
{
    /** @test */
    public function can_get_class_from_string()
    {
        // Act
        $class = app(RestrictionProvider::class)->getClass('weekly');

        // Assert
        $this->assertEquals(Weekly::class, $class);
    }
}