<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    public function __construct(private string $basePath)
    {
    }

    public function render(string $template, array $data = [])
    {
        extract($data);

        ob_start();
        include $this->resolve($template);
        return ob_get_clean();
    }

    public function resolve(string $path)
    {
        return "{$this->basePath}/{$path}.php";
    }
}
