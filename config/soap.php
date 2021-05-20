<?php

return [
    'services' => [
        'article' => [
            'name' => 'Article',
            'class' => 'App\Soap\Article\ArticleService',
            'exceptions' => ['Exception'],
            'types' => [
                'keyValue' => 'App\Soap\Article\Types\KeyValue',
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
        ]
    ],
    'logging' => true,
];
