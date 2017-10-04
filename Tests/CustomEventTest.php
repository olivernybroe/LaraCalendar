<?php

namespace Uruloke\LaraCalender\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Uruloke\LaraCalendar\Contracts\Eventable;
use Uruloke\LaraCalendar\Days\Tuesday;
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Models\HasEvent;
use Uruloke\LaraCalendar\Test\TestCase;

class CustomEvent extends TestCase
{
    /** @test */
    public function buildSimpleWeeklyRecurEvent()
    {
        // Arrange
        $builder = new EventBuilder();
        $builder->setEvent(EventWithData::class);
        $builder->title('02332 - Forelæsning');
        $builder->place('Building 306, DTU');
        $builder->description('Rum: 033');
        $builder->startsAt(Carbon::parse('2017-09-05 08:00'));
        $builder->endsAt(Carbon::parse('2017-09-05 18:00'));
        $builder->weekly(Tuesday::class);

        // Act
        /** @var EventWithData|Model $event */
        $event = $builder->getNextEvent();

        // Assert
        $this->assertInstanceOf(EventWithData::class, $event);
        $this->assertEquals($event->startsAt(), Carbon::parse('2017-09-05 08:00'));
        $this->assertEquals($event->endsAt(), Carbon::parse('2017-09-05 18:00'));
        $this->assertEquals('02332 - Forelæsning', $event->title);
        $this->assertEquals($builder->title(), $event->title);
        $this->assertArraySubset([
            'title'       => '02332 - Forelæsning',
            'place'       => 'Building 306, DTU',
            'description' => 'Rum: 033',
        ], $event->getAttributes());
    }

    /** @test */
    public function cannot_set_event_to_invalid_event_class()
    {
        // Arrange
        $builder = new EventBuilder();

        // Act / Assert
        $this->expectException(\InvalidArgumentException::class);
        $builder->setEvent(InvalidEvent::class);
    }
}

class InvalidEvent extends Model
{
}

class EventWithData extends Model implements Eventable
{
    use HasEvent;

    protected static $properties = [
        'title',
        'place',
        'description',
    ];
}
