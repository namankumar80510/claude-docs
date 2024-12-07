<?php

use App\Controller\DocumentationController;

/**
 * @var \League\Route\Router $router
 */

$router->get('/', function () {
    return new \Laminas\Diactoros\Response\RedirectResponse('/index');
});

$router->get('/{slug}', [DocumentationController::class, 'getDoc'])->setName('docs.show');
