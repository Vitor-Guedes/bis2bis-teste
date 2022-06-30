<?php

use App\Container;
use App\Database\Connection;
use App\Mvc\View;

$container = Container::getInstance();

$container->set('view', function () {
    return new View();
});

$container->set('settings', function () {
    return [
        'db' => [
            'host' => '198.25.1.5',
            'port' => '3306',
            'db_name' => 'blog',
            'user' => 'root',
            'pass' => ''
        ]
    ];
});

$container->set('db', function () use ($container) {
    $settings = $container->get('settings')['db'];
    $capsule = new Connection($settings);
    return $capsule->getConnection();
});