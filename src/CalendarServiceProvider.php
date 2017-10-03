<?php
namespace Uruloke\LaraCalendar;

use Illuminate\Support\ServiceProvider;
use Uruloke\LaraCalendar\Restrictions\RestrictionCollection;
use Uruloke\LaraCalendar\Restrictions\RestrictionProvider;

class CalendarServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerRestrictionMappings();
        $this->registerShortcutMappings();

    }
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton(RestrictionProvider::class, function () {
			return new RestrictionProvider();
		});

		$this->publishes([
			__DIR__.'/config.php' => config_path('calendar.php'),
		]);

		$this->mergeConfigFrom(
			__DIR__.'/config.php', 'calendar'
		);
	}

	private function registerRestrictionMappings ()
	{
		foreach (app(RestrictionProvider::class)->getClasses() as $mapName => $class) {
			EventBuilder::macro($mapName, function ($test) use ($class) {
				$arguments = func_get_args();

				$days = new RestrictionCollection($arguments[0]);
				unset($arguments[0]);
				$days->each(function ($day) use ($class, $arguments) {
					$this->restrictions->push(new $class($day, ...$arguments));
				});

				return $this;
			});
		}
	}

    private function registerShortcutMappings ()
    {
        foreach (app(RestrictionProvider::class)->getShortcuts() as $shortcut) {
            $array = explode("@", $shortcut);
            if (sizeof($array) != 2) {
                throw new \InvalidArgumentException("The shortcut is invalid formatted. [{$shortcut}]");
            }
            EventBuilder::macro($array[1], function () use ($array) {

                return call_user_func("{$array[0]}::{$array[1]}", $this, ...func_get_args());
            });
        }
    }
}