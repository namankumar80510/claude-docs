<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Library\Config\Config;
use App\Library\I18n\I18n;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * checks if the locale is supported; if not, redirects to the default locale
 * next, it sets up the locale for the application if supported.
 */
class LocaleMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $locale = $request->getAttribute('locale');
        $localeConfig = (require_once dirname(__DIR__, 2) . "/config/config.php")['i18n'] ?? [];

        // if the locale is not supported, redirect to the default locale
        if (!in_array($locale, array_keys($localeConfig['supported_locales']))) {
            return new RedirectResponse('/' . $localeConfig['default_locale'] . '/index');
        }

        // set the locale for the application
        I18n::init($locale);

        return $handler->handle($request);
    }
}
