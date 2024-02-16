<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    private array $globalTemplateDate = [];

    public function __construct(private string $basePath)
    {
    }

    public function render(string $template, array $data = [])
    {
        extract($data, EXTR_SKIP);
        extract($this->globalTemplateDate, EXTR_SKIP);

        ob_start();
        include $this->resolve($template);
        return ob_get_clean();
    }

    public function resolve(string $path)
    {
        return "{$this->basePath}/{$path}.php";
    }

    public function addGlobal(string $key, mixed $value)
    {
        $this->globalTemplateDate[$key] = $value;
    }
}
