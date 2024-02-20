<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Middleware\{TemplateDataMiddleware, ValidateExeptionMiddleware, SessionMiddleware, FlashMiddleware};

function registerMiddleware(App $app)
{
    $app->addMiddleWare(TemplateDataMiddleware::class);
    $app->addMiddleWare(ValidateExeptionMiddleware::class);
    $app->addMiddleWare(FlashMiddleware::class);
    $app->addMiddleWare(SessionMiddleware::class);
}
