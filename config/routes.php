<?php

/**
 * @var \League\Route\Router $router
 */

$router->get('/', function () {
    return new \Laminas\Diactoros\Response\HtmlResponse('Hello, World!');
});
