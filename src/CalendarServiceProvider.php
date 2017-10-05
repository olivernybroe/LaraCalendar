<?php

namespace Uruloke\LaraCalendar;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Uruloke\LaraCalendar\Restrictions\RestrictionProvider;
use Uruloke\LaraCalendar\Restrictions\RestrictionCollection;

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
        $this->registerCarbonMappings();
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

    private function registerRestrictionMappings()
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

    private function registerShortcutMappings()
    {
        foreach (app(RestrictionProvider::class)->getShortcuts() as $shortcut) {
            $array = explode('@', $shortcut);
            if (count($array) != 2) {
                throw new \InvalidArgumentException("The shortcut is invalid formatted. [{$shortcut}]");
            }
            EventBuilder::macro($array[1], function () use ($array) {
                return call_user_func("{$array[0]}::{$array[1]}", $this, ...func_get_args());
            });
        }
    }

    private function registerCarbonMappings()
    {
        Carbon::macro('isEvenWeek', function () {
            return $this->weekOfYear % 2 == 0;
        });

        Carbon::macro('isUnevenWeek', function () {
            return ! $this->isEvenWeek();
        });

        Carbon::macro('isWeek', function (int $week) {
            return $this->weekOfYear === $week;
        });
    }
}
