<?php

declare(strict_types=1);

function dd(mixed $value, $isStop = false)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';

    if ($isStop) {
        die();
    }
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value);
}
