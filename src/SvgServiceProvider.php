<?php

namespace Tovitch\Svg;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SvgServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::component(Svg::class, 'svg', config('laravel-svg.prefix'));

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-svg.php' => config_path('laravel-svg.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-svg'),
            ], 'views');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-svg');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-svg.php', 'laravel-svg');
    }
}
