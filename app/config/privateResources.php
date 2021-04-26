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
//        'holiday' => [
//            'create'
//        ],
//        'lateness' => [
//            'index',
//            'createStartDayTime',
//            'list',
//            'delete'
//        ],
//        'time' => [
//            'index',
//            'create',
//            'update',
//            'save'
//        ],
//        'session' => [
//            'login',
//            'authorize',
//            'logout'
//        ]
    ]
]);