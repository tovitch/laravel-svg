<?php

namespace Tovitch\Svg;

use Illuminate\View\Component;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class Svg extends Component
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

    public function resolve(): HtmlString
    {
        $filename = $this->getFilename(
            $this->getLibraryName()
        );

        if (! File::exists($filename)) {
            $filename = File::basename($filename);

            throw new \Exception("The file name [{$filename}] does not exist.");
        }

        $data = require $filename;

        return new HtmlString($data[$this->name]);
    }

    protected function getLibraryName(): string
    {
        $library = strtolower(config('laravel-svg.default'));

        if (is_null(config("laravel-svg.libraries.{$library}"))) {
            throw new \Exception("Library [{$library}] does not exist.");
        }

        return $library;
    }

    protected function getFilename(string $library): string
    {
        $options = config("laravel-svg.libraries.{$library}");

        $path = __DIR__ . '/Libraries/' . ucfirst($library);

        if (is_array($options) && array_key_exists('type', $options)) {
            $path .= '/' . $options['type'];
        }

        return "{$path}.php";
    }
}
