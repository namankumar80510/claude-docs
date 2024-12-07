<?php

declare(strict_types=1);

use Dikki\DotEnv\DotEnv;
use Tracy\Debugger;

require dirname(__DIR__) . '/vendor/autoload.php';

(new DotEnv(dirname(__DIR__)))->load();

if ($_ENV['APP_ENV'] === 'development') {
    Debugger::enable(Debugger::Development, __DIR__ . '/../tmp/log');
} else {
    Debugger::enable(Debugger::Production, __DIR__ . '/../tmp/log');
}

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$container = new \League\Container\Container;
$container->delegate(
    new \League\Container\ReflectionContainer(true)
);

$router = (new \League\Route\Router)
    ->setStrategy(
        (new \League\Route\Strategy\ApplicationStrategy)->setContainer($container)
    );

// map a route
$router->map('GET', '/', function (ServerRequestInterface $request): ResponseInterface {
    $response = new Laminas\Diactoros\Response;
    $response->getBody()->write('<h1>Hello, World!</h1>');
    return $response;
});

$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
