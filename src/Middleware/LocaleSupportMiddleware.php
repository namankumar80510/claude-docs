<?php

declare(strict_types=1);

namespace App\Middleware;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * checks if the locale is supported and sets it
 */
class LocaleSupportMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $locale = $request->getAttribute('locale');

        if (!in_array($locale, config('i18n.supported_locales'))) {
            return new RedirectResponse('/' . config('i18n.default_locale') . '/index');
        }

        return $handler->handle($request);
    }
}
