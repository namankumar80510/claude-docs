<?php

declare(strict_types=1);

namespace App\Library\View;

interface ViewInterface
{
    public function render(string $template, array $data = [], ?string $layout = null): string;
}
