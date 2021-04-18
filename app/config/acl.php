<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Component;

$acl = new AclList();

$acl->setDefaultAction(
    Enum::DENY
);

$roles = [
    'user'  => new Role('User'),
    'admin' => new Role('Admin'),
];

foreach ($roles as $role) {
    $acl->addRole($role);
}

$privateComponents = [
    'timesheet' => [
        'admin'
    ]
];
foreach ($privateComponents as $componentName => $actions) {
    $acl->addComponent(
        new Component($componentName),
        $actions
    );
}

$publicComponents = [
    'timesheet' => [
        'create'
    ]
];
foreach ($publicComponents as $componentName => $actions) {
    $acl->addComponent(
        new Component($componentName),
        $actions
    );
}

foreach ($roles as $role) {
    foreach ($publicComponents as $resource => $actions) {
        $acl->allow(
            $role->getName(),
            $resource,
            '*'
        );
    }
}

foreach ($privateComponents as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow(
            'Users',
            $resource,
            $action
        );
    }
}