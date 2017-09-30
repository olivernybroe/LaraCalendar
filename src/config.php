<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Maps
    |--------------------------------------------------------------------------
    |
    | Classes to map into the application. This is just an convenient wrapper
	| for the Macroable trait. It will map the constructor of the class to
	| the key.
    */
	'maps' => [
		'weekly' => \Uruloke\LaraCalendar\Restrictions\Weekly\Weekly::class,
		'notWeekly' => \Uruloke\LaraCalendar\Restrictions\Weekly\NotWeekly::class,
		'biWeekly' => \Uruloke\LaraCalendar\Restrictions\Weekly\BiWeekly::class,
		'evenWeeks' => \Uruloke\LaraCalendar\Restrictions\Weekly\EvenWeeks::class,
		'unevenWeeks' => \Uruloke\LaraCalendar\Restrictions\Weekly\UnevenWeeks::class,
		'withoutDay' => \Uruloke\LaraCalendar\Restrictions\Daily\WithoutDay::class,
		'withoutWeek' => \Uruloke\LaraCalendar\Restrictions\Weekly\WithoutWeek::class,
	],
	/*
	|--------------------------------------------------------------------------
	| Parsers
	|--------------------------------------------------------------------------
	|
	| Regex's used to parse a string to the given class. The class has to
	| implement Parseable.
	*/
	'parser' => [
		'^w{(\d+),(\d+)}' => \Uruloke\LaraCalendar\Restrictions\Weekly\Weekly::class,
		"^!w{(\d+),(\d+)}" => \Uruloke\LaraCalendar\Restrictions\Weekly\NotWeekly::class,
		"^w{(\d+)}" => \Uruloke\LaraCalendar\Restrictions\Weekly\Weekly::class,
		"^!w{(\d+)}" => \Uruloke\LaraCalendar\Restrictions\Weekly\NotWeekly::class,
		"^!d{(\d+-\d+-\d+)}" => \Uruloke\LaraCalendar\Restrictions\Daily\WithoutDay::class,
		"^%w{(\d+)}" => \Uruloke\LaraCalendar\Restrictions\Weekly\EvenWeeks::class,
		"^%%w{(\d+)}" => \Uruloke\LaraCalendar\Restrictions\Weekly\UnevenWeeks::class,
		"^!W{(\d+)}" => \Uruloke\LaraCalendar\Restrictions\Weekly\WithoutWeek::class,
	],
	'drivers' => [
		'event' => \Uruloke\LaraCalendar\Models\Event::class
	]
];
