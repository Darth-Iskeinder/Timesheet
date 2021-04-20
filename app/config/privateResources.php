<?php

use Phalcon\Config;
use Phalcon\Logger;

return new Config([
    'privateResources' => [
        'user' => [
            'index',
            'create',
            'update',
            'save',
            'delete',
            'changePassword'
        ],
        'time' => [
            'index',
            'create',
            'update',
            'save',
        ],
    ]
]);