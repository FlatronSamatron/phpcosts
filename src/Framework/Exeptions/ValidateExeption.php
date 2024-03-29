<?php

declare(strict_types=1);

namespace Framework\Exeptions;

use RuntimeException;

class ValidateExeption extends RuntimeException
{
    public function __construct(public array $errors, int $code = 422){
        parent::__construct();
    }
}
