<?php

declare(strict_types=1);

namespace router;

use exceptions\NotFoundException;

class APIRouter
{
    protected array $routes;

    public function register(string $route, string $method, string $controller): void
    {
        $this->routes[$route][$method] = $controller;
    }

    public function resolve(string $URL, string $method): string
    {
        $route = explode('?', $URL)[0];
        $controller = $this->routes[$route][$method] ?? null;

        if (!$controller) {
            $route = explode('/', $route);
            array_pop($route);
            $route = implode('/', $route) . '/*';
            $controller = $this->routes[$route][$method] ?? null;
        }

        if (!$controller) {
            http_response_code(404);
            throw new NotFoundException($URL);
        }

        if (class_exists($controller)) {
            $controller = new $controller;

            if (method_exists($controller, $method)) {
                return call_user_func_array([$controller, $method], []);
            }
        }

        http_response_code(404);
        throw new NotFoundException($URL);
    }
}
