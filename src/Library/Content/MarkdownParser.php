<?php

declare(strict_types=1);

namespace App\Library\Content;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownParser
{
    private MarkdownConverter $converter;

    public function __construct()
    {
        $environment = new Environment(require __DIR__ . '/../../../config/commonmark.php');

        $environment
            ->addExtension(new AttributesExtension())
            ->addExtension(new AutolinkExtension())
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new DisallowedRawHtmlExtension())
            ->addExtension(new ExternalLinkExtension())
            ->addExtension(new FrontMatterExtension())
            ->addExtension(new SmartPunctExtension())
            ->addExtension(new StrikethroughExtension())
            ->addExtension(new TableExtension())
            ->addExtension(new TaskListExtension());

        $this->converter = new MarkdownConverter($environment);
    }

    public function parse(string $markdown): ?array
    {
        $result = $this->converter->convert($markdown);

        $parsedArray = [];
        foreach ($result->getFrontMatter() as $key => $value) {
            $parsedArray[$key] = $value;
        }
        $parsedArray['content'] = $result->getContent();

        return $parsedArray;
    }

    public function parseString(string $markdown): string
    {
        return (new CommonMarkConverter())->convert($markdown)->getContent();
    }
}
