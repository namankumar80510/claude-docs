<?php

declare(strict_types=1);

namespace App\Library\Content;

use Dikki\Markdown\MarkdownParser;

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
        return $this->parser->getFileContent($relativePath);
    }
}
