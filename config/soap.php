<?php

return [
    'services' => [
        'article' => [
            'name' => 'Article',
            'class' => 'App\Soap\Article\ArticleService',
            'exceptions' => ['Exception'],
            'types' => [
                'article' => 'App\Soap\Article\Types\Article'
            ],
            'strategy' => 'AnyType',
            'headers' => [
                'Cache-Control' => 'no-cache, no-store'
            ],
            'options' => [
                'location' => 'http://127.0.0.1/soap/article/server',
                'trace' => 1
            ]
        ],
        'temperature' => [
            'name' => 'Temperature',
            'class' => 'App\Soap\Temperature\TemperatureService',
            'exceptions' => ['Exception'],
            'types' => [
                'temperature' => 'App\Soap\Temperature\Types\Temperature'
            ],
            'strategy' => 'AnyType',
            'headers' => [
                'Cache-Control' => 'no-cache, no-store'
            ],
            'options' => [
                'location' => 'http://127.0.0.1/soap/temperature/server',
                'trace' => 1
            ]
        ]

    ],
    'logging' => true,
];
