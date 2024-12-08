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
        
        // Clean and normalize the search query
        $query = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $query);
        $query = preg_replace('/\s+/', ' ', $query);
        $query = trim(strtolower($query));
        
        if (empty($query)) {
            return null;
        }

        $searchTerms = array_filter(explode(' ', $query));
        $results = [];
        $scores = [];

        foreach ($allArticles as $index => $article) {
            $content = strtolower($article['content']);
            $title = strtolower($article['title']);
            
            $score = 0;
            $matches = true;

            foreach ($searchTerms as $term) {
                // Check exact matches first
                if (strpos($title, $term) !== false) {
                    $score += 10;
                } elseif (strpos($content, $term) !== false) {
                    $score += 5;
                } else {
                    // Check for similar terms using levenshtein distance
                    $titleWords = explode(' ', $title);
                    $contentWords = explode(' ', $content);
                    $foundSimilar = false;
                    
                    foreach ($titleWords as $word) {
                        if (levenshtein($term, $word) <= 2) {
                            $score += 8;
                            $foundSimilar = true;
                            break;
                        }
                    }
                    
                    if (!$foundSimilar) {
                        foreach ($contentWords as $word) {
                            if (levenshtein($term, $word) <= 2) {
                                $score += 3;
                                $foundSimilar = true;
                                break;
                            }
                        }
                    }
                    
                    if (!$foundSimilar) {
                        $matches = false;
                        break;
                    }
                }
            }

            if ($matches && $score > 0) {
                $results[] = $article;
                $scores[] = $score;
            }
        }

        if (empty($results)) {
            return null;
        }

        // Sort results by score
        array_multisort($scores, SORT_DESC, $results);
        
        return $results;
    }
}
