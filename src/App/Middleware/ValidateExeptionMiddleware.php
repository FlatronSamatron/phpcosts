<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exeptions\ValidateExeption;

class ValidateExeptionMiddleware implements MiddlewareInterface
{
    public function __construct()
    {
    }

    public function process(callable $next)
    {
        try {
            $next();
        } catch (ValidateExeption $e) {

            $oldFormData = array_filter($_POST, fn($key) => $key !== "password" && $key !== "confirmPassword", ARRAY_FILTER_USE_KEY);

            $_SESSION['errors'] = $e->errors;
            $_SESSION['oldFormData'] = $oldFormData;

            redirectTo("/register");
        }
    }
}
