<?php


namespace Uruloke\LaraCalendar\Contracts\Restrictions;


interface Parseable
{
	/**
	 * @return Restrictionable
	 *
	 * Parse in the parameters for converting from string to the
	 * class.
	 */
	public static function parse() : Restrictionable;

}