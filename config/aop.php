<?php

return [
    'debug' => true,
    'cache' => storage_path().'/framework/cache/aop',
    'includePaths' => [
        app_path() . '/Domain/',
        app_path() . '/Infrastructure/',
        base_path() . '/tests/'
    ]
];