<?php

declare(strict_types=1);

namespace App\Library\Content;

use Dikki\Markdown\MarkdownParser;
use Nette\Utils\Finder;
use Nette\Utils\Strings;

class ContentParser
{
    public const DOCS_DIR = __DIR__ . '/../../../docs';
    private MarkdownParser $parser;

    public function __construct()
    {
        $this->parser = new MarkdownParser($this->getContentDir());
    }

    public function getArticles(): array
    {
        $mdFiles = Finder::findFiles('*.md')->from($this->getContentDir());
        $contents = [];
        foreach ($mdFiles as $mdFile) {
            $content = $this->parser->getFileContent(str_replace('.md', '', $mdFile->getRelativePathname()));
            if (!$content) {
                continue;
            }
            $content['slug'] = str_replace('.md', '', $mdFile->getRelativePathname());
            $contents[] = $content;
        }
        return $contents;
    }

    public function getArticle(string $slug): ?array
    {
        $content = $this->parser->getFileContent($slug);
        if (!$content) {
            return null;
        }
        $content['slug'] = $slug;
        $content['content'] = $this->modifyContentString($content['content']);
        $content['toc'] = $this->getToc($content['content']);
        return $content;
    }

    private function getContentDir(): string
    {
        return rtrim(self::DOCS_DIR, '/') . '/' . locale() . '/content/';
    }

    private function modifyContentString(string $content): string
    {
        $content = Strings::replace($content, '#<h(\d)>(.*?)</h\d>#', function ($matches) {
            $level = $matches[1];
            $text = $matches[2];
            $id = Strings::webalize($text);
            return "<h{$level} id=\"{$id}\">{$text}</h{$level}>";
        });
        return $content;
    }

    private function getToc(string $content): string
    {
        $toc = '<ul class="toc">';
        preg_match_all('#<h([2-3]) id="(.*?)">(.*?)</h[2-3]>#', $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $level = $match[1];
            $id = $match[2];
            $text = $match[3];
            $indent = $level == 3 ? 'ml-4' : '';
            $toc .= "<li class=\"{$indent}\"><a href=\"#{$id}\">{$text}</a></li>";
        }

        $toc .= '</ul>';
        return $toc;
    }
}
