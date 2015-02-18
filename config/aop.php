<?php

return [
    'debug' => true,
    'cache' => storage_path().'/framework/cache/aop',
    'includePaths' => [
        app_path() . '/app/Domain/',
        base_path() . '/tests/'
    ]
];