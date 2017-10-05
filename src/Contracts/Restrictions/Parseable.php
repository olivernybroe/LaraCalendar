<?php

namespace Uruloke\LaraCalendar\Contracts\Restrictions;

use Illuminate\Contracts\Support\Arrayable;

interface Parseable extends Arrayable
{
    /**
     * @return Restrictionable
     *
     * Parse in the parameters for converting from string to the
     * class.
     */
    public static function parse() : Restrictionable;

    public function __toString() : string;
}
