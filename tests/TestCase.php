<?php

namespace Tovitch\Svg\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Tovitch\Svg\SvgServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Tovitch\\Svg\\Database\\Factories\\' . class_basename(
                    $modelName
                ) . 'Factory'
        );
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set(
            'database.connections.sqlite',
            [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        );

        /*
        include_once __DIR__.'/../database/migrations/create_laravel_svg_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }

    protected function getPackageProviders($app)
    {
        return [
            SvgServiceProvider::class,
        ];
    }
}
