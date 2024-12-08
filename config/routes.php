<?php

use App\Controller\DocumentationController;
use App\Controller\SearchController;
use App\Middleware\APIAuthMiddleware;
use App\Middleware\CORSMiddleware;
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

$router->group('/{locale}', function ($router) {
    $router->get('/search', [SearchController::class, 'getSearchResults'])->setName('search');
    $router->get('/home', [DocumentationController::class, 'getHome'])->setName('home');
    $router->get('/{slug}', [DocumentationController::class, 'getDoc'])->setName('docs.show');
});

// API ROUTES
$router->group('/api/v1', function ($router) {
    $router->post('/ask-ai', [SearchController::class, 'getAIResponse'])->setName('api.ask-ai');
})->middleware(new CORSMiddleware())->middleware(new APIAuthMiddleware());
