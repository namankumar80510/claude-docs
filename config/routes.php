<?php

use App\Controller\DocumentationController;
use App\Controller\SearchController;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @var \League\Route\Router $router
 */

$router->get('/', function () {
    $defaultLocale = config('i18n.default_locale');
    return new RedirectResponse("/{$defaultLocale}/home");
});

$router->get('/{locale}', function (ServerRequestInterface $request) {
    $locale = $request->getAttribute('locale');
    return new RedirectResponse("/{$locale}/home");
});

$router->get('/{locale}/search', [SearchController::class, 'getSearchResults'])->setName('search');
$router->get('/{locale}/home', [DocumentationController::class, 'getHome'])->setName('home');
$router->get('/{locale}/{slug}', [DocumentationController::class, 'getDoc'])->setName('docs.show');
