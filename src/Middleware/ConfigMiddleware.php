<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Library\Config\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Initialize configuration
 */
class ConfigMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        Config::init(locale());
        return $handler->handle($request);
    }
}
