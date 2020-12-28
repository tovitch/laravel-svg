<?php

namespace Tovitch\Svg;

use Illuminate\View\Component;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\View;

abstract class Svg extends Component
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function render()
    {
        return View::make('laravel-svg::svg');
    }

    public function defaultAttributes(): array
    {
        return [];
    }

    abstract public function innerTag(): HtmlString;
}
