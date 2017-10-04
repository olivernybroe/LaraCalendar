<?php

namespace Uruloke\LaraCalendar\Restrictions;

use Illuminate\Support\Collection;

class RestrictionCollection extends Collection
{
    protected function getArrayableItems($items)
    {
        if ($items instanceof \DateTimeInterface) {
            return [$items];
        }

        return parent::getArrayableItems($items);
    }
}
