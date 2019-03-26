<?php
return [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig' => [
                'cache' => false, //__DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
        ],
    ],
];
