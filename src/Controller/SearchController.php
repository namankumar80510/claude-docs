<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\Content\SearchContent;
use App\Library\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class SearchController
{

    public function __construct(
        private ViewInterface $view,
        private SearchContent $searchContent
    ) {}

    public function getSearchResults(ServerRequestInterface $request): ResponseInterface
    {
        $query = $request->getQueryParams()['q'];
        $results = $this->searchContent->search($query);
        return new HtmlResponse($this->view->render('search/show', ['query' => $query, 'results' => $results]));
    }
}
