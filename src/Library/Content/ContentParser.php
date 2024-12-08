<?php

declare(strict_types=1);

namespace App\Library\Content;

use Dikki\Markdown\MarkdownParser;
use Nette\Utils\Finder;

class ContentParser
{
    public const DOCS_DIR = __DIR__ . '/../../../docs';
    private MarkdownParser $parser;

    public function __construct()
    {
        $this->parser = new MarkdownParser(self::DOCS_DIR);
    }

    public function getContent(string $relativePath): ?array
    {
        $mdFiles = Finder::findFiles('*.md')->from(self::DOCS_DIR);
        foreach ($mdFiles as $mdFile) {
            $content = $this->parser->getFileContent(str_replace('.md', '', $mdFile->getRelativePathname()));
            $content['slug'] = str_replace('.md', '', $mdFile->getRelativePathname());
            dump($content);
            die;
        }
    }
}   
