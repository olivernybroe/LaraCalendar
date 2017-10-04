<?php

namespace Uruloke\LaraCalendar\Contracts;

use Illuminate\Support\Carbon;

interface Eventable
{
    public function startsAt() : Carbon;

    public function endsAt() : Carbon;

    public static function getEventProperties() : array;

    public static function hasEventProperty(string $key) : bool;

    public function setEnds(\DateTimeInterface $ends);

    public function setStart(\DateTimeInterface $start);
}
