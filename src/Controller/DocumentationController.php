<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\Content\ContentParser;
use App\Library\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class DocumentationController
{

    public function __construct(
        private ViewInterface $view,
        private ContentParser $contentParser
    ) {}

    public function getHome(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->view->render('docs/home'));
    }

    public function getDoc(ServerRequestInterface $request): ResponseInterface
    {
        $slug = $request->getAttribute('slug');

        $content = $this->contentParser->getArticle($slug);

        if (!$content) {
            return new HtmlResponse($this->view->render('errors/404', [], null), 404);
        }

        return new HtmlResponse(
            $this->view->render('docs/show', $content)
        );
    }
}
