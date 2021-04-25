<?php
use Phalcon\Mvc\Router;

// Create the router
$router = new Router();

$router->add('/login', [
        'controller' => 'session',
        'action' => 'login',
]);

$router->add('/lateness', [
    'controller' => 'lateness',
    'action' => 'index',
]);

$router->add('/user', [
    'controller' => 'user',
    'action' => 'index',
]);

$router->add('/timesheet', [
    'controller' => 'timesheet',
    'action' => 'index',
]);

$router->add('/time', [
    'controller' => 'time',
    'action' => 'update',
]);

return $router;