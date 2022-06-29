<?php

$app->get('/', function ($request, $response)    {
    $response->setBody("#Home");
    return $response;
});