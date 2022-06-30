<?php

use Code\Admin\Middleware\IsLogged;

$app->get('/', function ($request, $response)    {
    $response->setBody("#Home");
    return $response;
});

$app->group('/admin', function ($route) {
    $controller = \Code\Admin\Controller\Index::class;
    
    $route->get('', "$controller@login");

    $route->post('/authenticate', "$controller@authenticate");

    $route->get('/dash', "$controller@dash")->before(new IsLogged);

    $route->get('/loggout', "$controller@loggout");
});