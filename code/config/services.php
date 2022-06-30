<?php

use App\Container;
use App\Mvc\View;

$container = Container::getInstance();

$container->set('view', function () {
    return new View();
});