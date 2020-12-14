<?php

return [
    'prefix'  => env('LARAVEL_SVG_PREFIX'),
    'default' => env('LARAVEL_SVG_LIB', 'heroicons'),

    'libraries' => [
        'heroicons' => [
            'type' => env('LARAVEL_SVG_HEROICON_TYPE', 'outline'),
        ],
    ],
];
