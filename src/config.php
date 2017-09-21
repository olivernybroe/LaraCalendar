<?php

return [
	'maps' => [
		'weekly' => \Uruloke\LaraCalendar\Restrictions\Weekly\Weekly::class,
		'notWeekly' => \Uruloke\LaraCalendar\Restrictions\Weekly\NotWeekly::class,
		'biWeekly' => \Uruloke\LaraCalendar\Restrictions\Weekly\BiWeekly::class,
		'evenWeeks' => \Uruloke\LaraCalendar\Restrictions\Weekly\EvenWeeks::class,
		'unevenWeeks' => \Uruloke\LaraCalendar\Restrictions\Weekly\UnevenWeeks::class
	],
	'drivers' => [
		'event' => \Uruloke\LaraCalendar\Models\Event::class
	]
];
