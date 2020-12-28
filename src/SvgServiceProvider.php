<?php

namespace Tovitch\Svg;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SvgServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-svg.php' => config_path('laravel-svg.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-svg'),
            ], 'views');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-svg');

        $this->loadViewComponentsAs(config('laravel-svg.prefix'), [
            'svg' => $this->resolveLibraryClass(),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-svg.php', 'laravel-svg');
    }

    protected function resolveLibraryClass()
    {
        $library = config('laravel-svg.default');

        if (is_null(config("laravel-svg.libraries.{$library}"))) {
            throw new \Exception("Library [{$library}] does not exist.");
        }

        $library = ucfirst($library);

        return "Tovitch\\Svg\\Libraries\\{$library}\\{$library}Svg";
    }
}
