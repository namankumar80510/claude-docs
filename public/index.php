<?php

declare(strict_types=1);

use App\Library\Config\Config;
use App\Library\I18n\I18n;
use App\Library\Router\RoutingStrategy;
use App\Middleware\LocaleSupportMiddleware;
use Dikki\DotEnv\DotEnv;
use Tracy\Debugger;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\Router;

require dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables
(new DotEnv(dirname(__DIR__)))->load();

// Initialize configuration
Config::init();

// Configure debugger based on environment
$logDir = dirname(__DIR__) . '/tmp/log';
$debugMode = config('app.env') === 'development' ? Debugger::Development : Debugger::Production;
Debugger::enable($debugMode, $logDir);

// Initialize i18n
I18n::init();

// Create PSR-7 request from globals
$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

// Set up dependency injection container
$container = new Container;
$services = require dirname(__DIR__) . '/config/services.php';
foreach ($services as $name => $concrete) {
    $container->add($name, $concrete);
}
$container->delegate(
    new ReflectionContainer(true)
);

// Configure router with container-aware strategy
$strategy = (new RoutingStrategy)->setContainer($container);
$router = (new Router)->setStrategy($strategy);
$router->middleware(new LocaleSupportMiddleware());

// Load routes configuration
require dirname(__DIR__) . '/config/routes.php';

// Handle request and get response
$response = $router->handle($request);

// Output response
(new SapiEmitter)->emit($response);
