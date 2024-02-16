<?php

declare(strict_types=1);

namespace Framework;

class App
{
    private Router $router;
    private Container $container; //dependency injection

    public function __construct(string $containerDefenitionsPath = null)
    {
        $this->router = new Router(); //object(Framework\App)#4 (1) { ["routers":"Framework\App":private]=> object(Framework\Router)#2 (0) { } } app
        $this->container = new Container(); //dependency injection

        if ($containerDefenitionsPath) {
            $containerDefenitions = include $containerDefenitionsPath;
            $this->container->addDefenition($containerDefenitions);
        }
    }

    public function run()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->dispatch($path, $method, $this->container);
    }

    public function get(string $path, array $controller)
    {
        $this->router->add('GET', $path, $controller);
        return $this;
    }

    public function addMiddleWare(string $middleware)
    {
        $this->router->addMiddleware($middleware);
    }
}
