<?php

namespace Uruloke\LaraCalendar\Restrictions;

use Uruloke\LaraCalendar\Contracts\Restrictions\Parseable;

/**
 * Trait CanParse.
 * @mixin Parseable
 */
trait CanParse
{
    public function __toString() : string
    {
        $parser = app(RestrictionProvider::class)->getParserFromClass(get_class($this));
        $replacements = collect($this->toArray());

        return preg_replace_callback("/\(.*?\)/", function () use (&$replacements) {
            return $replacements->shift();
        }, $parser);
    }
}
