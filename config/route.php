<?php
return [
    '/api/v1/' => [
        'namespace' => 'Application\\Procedures',
        'before' => [
            \Routeless\Middlewares\CORS::class,
            \Application\MiddleWares\JwtToken::class,
        ],
        'after' => [
            \Routeless\Middlewares\ApplicationJson::class
        ]
    ]
];
