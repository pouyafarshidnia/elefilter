<?php

namespace EleFilter;

use Illuminate\Support\ServiceProvider;
use EleFilter\Commands\MakeFilterCommand;
use EleFilter\Macros\Macro;

class EleFilterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([MakeFilterCommand::class]);
        }

        $this->mergeConfigFrom(__DIR__ . '/config/elefilter.php', 'elefilter');
    }

    public function boot(): void
    {
        $this->publishes([__DIR__ . '/config/elefilter.php' => config_path('elefilter.php')], 'elefilter');

        Macro::register();
    }
}
