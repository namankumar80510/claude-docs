<?php

declare(strict_types=1);

namespace App\Library\Router;

use App\Middleware\NotFoundMiddleware;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Server\MiddlewareInterface;

class RoutingStrategy extends ApplicationStrategy
{
    public function getNotFoundDecorator(NotFoundException $exception): MiddlewareInterface
    {
        return new NotFoundMiddleware();
    }
}
