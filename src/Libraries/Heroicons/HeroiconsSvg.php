<?php

namespace Tovitch\Svg\Libraries\Heroicons;

use Tovitch\Svg\Svg;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\File;

class HeroiconsSvg extends Svg
{
    public function innerTag(): HtmlString
    {
        $data = require __DIR__ . "/{$this->getType()}.php";

        return new HtmlString($data[$this->name]);
    }

    public function isOutline(): bool
    {
        return $this->getType() === 'outline';
    }

    public function defaultAttributes(): array
    {
        if ($this->isOutline()) {
            return [
                'viewBox' => '0 0 24 24',
                'stroke' => 'currentColor',
                'stroke-width' => '2',
                'fill' => 'none',
            ];
        }

        return [
            'viewBox' => '0 0 20 20',
            'stroke' => 'none',
            'fill' => 'currentColor',
        ];
    }

    protected function getType(): string
    {
        $type = $this->attributes->get(
            'type',
            config('laravel-svg.libraries.heroicons.type')
        );

        if (! File::exists(__DIR__ . "/{$type}.php")) {
            throw new \Exception("The type [{$type}] does not exist.");
        }

        return $type;
    }
}
