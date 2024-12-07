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

    public function getDoc(ServerRequestInterface $request): ResponseInterface
    {
        $slug = $request->getAttribute('slug');

        $content = $this->contentParser->getContent($slug);

        if (!$content) {
            return new HtmlResponse('Not found', 404);
        }

        return new HtmlResponse(
            $this->view->render('docs/show', $content)
        );
    }
}
