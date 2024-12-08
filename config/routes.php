<?php

use App\Controller\DocumentationController;
use Laminas\Diactoros\Response\RedirectResponse;

/**
 * @var \League\Route\Router $router
 */

$router->get('/', function () {
    $defaultLocale = config('i18n.default_locale');
    return new RedirectResponse("/{$defaultLocale}/index");
});

$router->get('/{locale}/{slug}', [DocumentationController::class, 'getDoc'])->setName('docs.show');
