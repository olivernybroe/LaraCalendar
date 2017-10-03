<?php
namespace Uruloke\LaraCalendar\Test;

use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\Contracts\Eventable;
use Uruloke\LaraCalendar\Restrictions\Weekly\Weekly;
use Uruloke\LaraCalendar\TestFacade;
use Uruloke\LaraCalendar\CalendarServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
abstract class TestCase extends OrchestraTestCase
{
	/**
	 * Load package service provider
	 * @param  \Illuminate\Foundation\Application $app
	 * @return array
	 */
	protected function getPackageProviders($app)
	{
		return [CalendarServiceProvider::class];
	}
	/**
	 * Load package alias
	 * @param  \Illuminate\Foundation\Application $app
	 * @return array
	 */
	protected function getPackageAliases($app)
	{
		return [
		];
	}

	protected function assertStringContains ($expected, $actual)
	{
		$this->assertTrue(
			$this->stringContains($expected)->evaluate($actual, "", true)
		);
	}

	protected function assertContainsInstancesOf ($expected, $haystack)
	{
		$contains = false;
		foreach ($haystack as $item) {
			if ($item instanceof $expected) {
				$contains = true;
			}
		}

		$this->assertTrue($contains, "The haystack does not contain the expected class [{$expected}]");
	}

    protected function assertEventDays (Eventable $first, $startAt, $endsAt)
    {
        $this->assertEquals(Carbon::parse($startAt), $first->startsAt());
        $this->assertEquals(Carbon::parse($endsAt), $first->endsAt());
    }
}