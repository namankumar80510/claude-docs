<?php

declare(strict_types=1);

namespace App\Library\View;

use League\Plates\Engine;
use League\Plates\Template\Template;

class PlatesRenderer implements ViewInterface
{
    private Engine $plates;

    public function __construct()
    {
        $this->plates = new Engine(dirname(__DIR__, 3) . '/templates', 'phtml');
    }

    public function render(string $template, array $data = [], ?string $layout = 'layouts/base'): string
    {
        $data['config'] = config();
        $data['locale'] = locale();
        $renderer = new Template($this->plates, $template);
        $renderer->data($data);
        if ($layout) {
            $renderer->layout($layout, $data);
        }
        return $renderer->render($data);
    }
}
