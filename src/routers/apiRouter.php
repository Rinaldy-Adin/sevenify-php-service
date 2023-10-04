<?php

declare(strict_types=1);

namespace router;

use exceptions\NotFoundException;

class APIRouter
{
    protected array $routes;

    public function register(string $route, string $method, object $controller) : void
    {
        $this->routes[$route][$method] = $controller;
    }

    public function resolve(string $URL, string $method) : string
    {
        $route = explode('?', $URL)[0];
        $controller = $this->routes[$route][$method] ?? null;

        if (!$controller) {
            throw new NotFoundException();
        }

        if (class_exists($controller)) {
            $controller = new $controller;

            if (method_exists($controller, $method)) {
                return call_user_func_array([$controller, $method], []);
            }
        }

        throw new NotFoundException();
    }
}
