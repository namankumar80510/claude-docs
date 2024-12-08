<?php

declare(strict_types=1);

namespace App\Library\Content;

class SearchContent
{

    public function __construct(
        private ContentParser $contentParser
    ) {}

    public function search(string $query, string $locale = null): ?array
    {
        $allArticles = $this->contentParser->getArticles($locale);
        $searchTerms = array_filter(explode(' ', strtolower($query)));
        
        $results = [];
        foreach ($allArticles as $article) {
            $content = strtolower($article['content']);
            $title = strtolower($article['title']);
            
            $matchesAllTerms = true;
            foreach ($searchTerms as $term) {
                if (strpos($content, $term) === false && strpos($title, $term) === false) {
                    $matchesAllTerms = false;
                    break;
                }
            }
            
            if ($matchesAllTerms) {
                $results[] = $article;
            }
        }
        
        return empty($results) ? null : $results;
    }
}
