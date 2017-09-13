<?php

namespace Uruloke\LaraCalendar\Restrictions;

use Illuminate\Support\Collection;

class RestrictionCollection extends Collection
{
	public function anyMatch(callable $callback) : bool {
		foreach ($this->items as $key => $item) {
			if($callback($item)){
				return true;
			}
		}
		return false;
	}

	public function allMatch(callable  $callback) : bool {
		foreach ($this->items as $key => $item) {
			if(!$callback($item)){
				return false;
			}
		}
		return true;
	}
}