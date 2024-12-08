<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Library\View\PlatesRenderer;
use App\Library\View\ViewInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundMiddleware implements MiddlewareInterface
{

    private PlatesRenderer $view;

    public function __construct()
    {
        $this->view = new PlatesRenderer();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new HtmlResponse($this->view->render('errors/404', [
            'locale' => locale(),
        ], null), 404);
    }
}
