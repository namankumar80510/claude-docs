<?php

declare(strict_types=1);

namespace App\Library\Content;

use Nette\Utils\FileSystem;
use Nette\Utils\Finder;
use Nette\Utils\Strings;
use SplFileInfo;

class ContentParser
{
    public const DOCS_DIR = __DIR__ . '/../../../docs';
    private MarkdownParser $parser;

    public function __construct()
    {
        $this->parser = new MarkdownParser();
    }

    public function getArticles(string $locale = null): array
    {
        $mdFiles = Finder::findFiles('*.md')->in($this->getContentDir($locale));
        $contents = [];
        foreach ($mdFiles as $mdFile) {
            $content = $this->getParsedFileContent($mdFile);
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
        $content = $this->getParsedFileContent($slug);
        if (!$content) {
            return null;
        }
        $content['slug'] = $slug;
        $content['content'] = $this->modifyContentString($content['content']);
        $content['toc'] = $this->getToc($content['content']);
        return $content;
    }

    private function getParsedFileContent(SplFileInfo|string $slug): ?array
    {
        if (!is_string($slug)) {
            $filePath = $slug->getPathname();
        } else {
            $filePath = $this->getContentDir() . '/' . $slug . '.md';
        }
        if (!file_exists($filePath)) {
            return null;
        }
        $mdFileContent = FileSystem::read($filePath);
        return $this->parser->parse($mdFileContent);
    }

    private function getContentDir(string $locale = null): string
    {
        if (!$locale) {
            $locale = locale();
        }
        return rtrim(self::DOCS_DIR, '/') . '/' . $locale . '/content/';
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
