<?php

namespace Tovitch\Svg\Tests;

use Illuminate\Support\Facades\File;
use Illuminate\View\ComponentAttributeBag;
use Tovitch\Svg\Libraries\Heroicons\HeroiconsSvg;

class SvgComponentTest extends TestCase
{
    /** @test */
    public function it_renders_the_component()
    {
        $data = require __DIR__ . '/../src/Libraries/Heroicons/outline.php';
        $name = 'adjustments';

        $component = new HeroiconsSvg($name);
        $component->attributes = new ComponentAttributeBag;

        $view = $component->render();

        $svg = $view->with([
            'attributes' => $component->attributes,
            'innerTag' => fn () => $component->innerTag(),
            'defaultAttributes' => fn () => $component->defaultAttributes(),
        ])->render();

        $this->assertEquals($name, $component->name);
        $this->assertEquals('svg.blade.php', File::basename($view->getPath()));
        $this->assertArrayHasKey('name', $component->data());
        $this->assertEquals($name, $component->data()['name']);
        $this->assertEquals($data[$name], $component->innerTag());
        $this->assertStringContainsString($data[$name], $svg);
    }

    /** @test */
    public function it_throws_an_exception_if_the_file_is_not_found()
    {
        $this->expectException(\Exception::class);

        $this->app['config']->set('laravel-svg.libraries.heroicons.type', 'foobar');

        $component = new HeroiconsSvg('adjustments');
        $component->attributes = new ComponentAttributeBag;

        $view = $component->render();

        $view->with([
            'attributes' => $component->attributes,
            'innerTag' => fn () => $component->innerTag(),
            'defaultAttributes' => fn () => $component->defaultAttributes(),
        ])->render();
    }
}
