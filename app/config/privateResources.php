<?php

use Phalcon\Config;

return new Config([
    'privateResources' => [
        'user' => [
            'index',
            'create',
            'update',
            'save',
            'delete'
        ],
        'timesheet' => [
            'index',
            'createStart',
            'createEnd',
            'changePassword'
        ],
        'holiday' => [
            'create'
        ],
        'lateness' => [
            'index',
            'createStartDayTime',
            'list',
            'delete'
        ],
        'time' => [
            'index',
            'create',
            'update',
            'save'
        ]
    ]
]);