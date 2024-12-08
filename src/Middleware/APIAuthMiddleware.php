<?php

namespace App\Middleware;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class APIAuthMiddleware implements MiddlewareInterface
{
    private const API_ROUTES = [
        '/api/v1/ask-ai'
    ];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();

        if (!in_array($path, self::API_ROUTES)) {
            return $handler->handle($request);
        }

        $secret = $request->getHeaderLine('secret');

        if ($secret !== $_ENV['APP_SECRET']) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        return $handler->handle($request);
    }
}
