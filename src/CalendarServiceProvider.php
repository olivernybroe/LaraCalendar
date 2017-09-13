<?php
namespace Uruloke\LaraCalendar;

use Illuminate\Support\ServiceProvider;
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
}