<?php

function int_to_day(int $dayAsInt)
{
	foreach (\Uruloke\LaraCalendar\EventBuilder::$days as $dayClass) {
		if($dayClass::dayAsNumber() == $dayAsInt) {
			return $dayClass;
		}
	}
	return null;
}
