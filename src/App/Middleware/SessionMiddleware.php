<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exeptions\SessionExeption;

class SessionMiddleware implements MiddlewareInterface{
    public function process(callable $next)
    {
        if(session_status() === PHP_SESSION_ACTIVE){
            throw new SessionExeption("Session already active");
        }
        
        if(headers_sent($filename, $line)){
            throw new SessionExeption("Headers already sent. in file {$filename} on line {$line}");
        }

        session_start();

        $next();

        session_write_close();
    }
}