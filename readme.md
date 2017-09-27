[![Build Status](https://travis-ci.org/uruloke/LaraCalendar.svg?branch=master)](https://travis-ci.org/uruloke/LaraCalendar)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Latest Stable Version](https://poser.pugx.org/uruloke/lara-calendar/v/stable)](https://packagist.org/packages/uruloke/lara-calendar)
[![Total Downloads](https://poser.pugx.org/uruloke/lara-calendar/downloads)](https://packagist.org/packages/uruloke/lara-calendar)

Documentation is still in development.

## Introduction
When building an calendar it can be troublesome when dealing with recurring events, this package is trying to solve this problem by making and easy to use builder syntax with easy extensibility. <br>

Install it via composer
```
$ composer require uruloke/lara-calendar
```


## Example
Let's say we wan't to create an event which repeats monday, tuesday, wednesday amd thursday each week.
We can generate this simply by doing the following

```php
$builder = new EventBuilder();
$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
$builder->weekly([Monday::class, Tuesday::class, Wednesday::class, Thursday::class]);

// Dump the results
$builder->getNextEvents(3)

```
The dumped data for the next 3 events would then be.
```		
Uruloke\LaraCalendar\EventCollection {#221
  #items: array:3 [
    0 => Uruloke\LaraCalendar\Models\Event {#225
      #start: Uruloke\LaraCalendar\Carbon {#230
        +"date": "2017-09-05 08:00:00.000000"
        +"timezone_type": 3
        +"timezone": "UTC"
      }
      #ends: Uruloke\LaraCalendar\Carbon {#231
        +"date": "2017-09-05 18:00:00.000000"
        +"timezone_type": 3
        +"timezone": "UTC"
      }
    }
    1 => Uruloke\LaraCalendar\Models\Event {#232
      #start: Uruloke\LaraCalendar\Carbon {#233
        +"date": "2017-09-06 08:00:00.000000"
        +"timezone_type": 3
        +"timezone": "UTC"
      }
      #ends: Uruloke\LaraCalendar\Carbon {#234
        +"date": "2017-09-06 18:00:00.000000"
        +"timezone_type": 3
        +"timezone": "UTC"
      }
    }
    2 => Uruloke\LaraCalendar\Models\Event {#235
      #start: Uruloke\LaraCalendar\Carbon {#236
        +"date": "2017-09-07 08:00:00.000000"
        +"timezone_type": 3
        +"timezone": "UTC"
      }
      #ends: Uruloke\LaraCalendar\Carbon {#237
        +"date": "2017-09-07 18:00:00.000000"
        +"timezone_type": 3
        +"timezone": "UTC"
      }
    }
  ]
}
```
## Recurrences

### Weekly

### BiWeekly

### EvenWeeks

### UnevenWeeks


## Filters

### Filter days out
There might be a specific day which you won't to blacklist from your event, this can be achieved with `withoutDay` method.
Just parse in a day and it will ignore that specific day.

```
$builder = new EventBuilder();
$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
$builder->allWeekDays();
$builder->withoutDay(Carbon::parse("2017-09-07"));
```