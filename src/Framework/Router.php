<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function add(string $method, string $path, array $controller)
    {
        $path = $this->normilizePath($path);

        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller
        ];
    }

    private function normilizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);

        return $path;
    }

    public function dispatch(string $path, string $method, Container $container = null)
    {
        $path = $this->normilizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (!!preg_match("#^{$route['path']}$#", $path)) {
                [$class, $function] = $route['controller'];
                $controllerInstance = $container ? $container->resolve($class) : new $class;
                $action = fn () => $controllerInstance->$function();

                //chaining calback functions
                foreach ($this->middlewares as $middleware) {
                    $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
                    $action = fn () => $middlewareInstance->process($action);
                }

                $action();

                return;
            }
        }
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
