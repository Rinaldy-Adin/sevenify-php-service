<?php

declare(strict_types=1);

namespace router;

use exceptions\NotFoundException;

class APIRouter
{
    protected array $routes;

    private function register(string $route, string $method, callable $action)
    {
        $this->routes[$route][$method] = $action;
    }

    public function get(string $route, callable $action)
    {
        $this->register($route, 'get', $action);
    }

    public function post(string $route, callable $action)
    {
        $this->register($route, 'post', $action);
    }

    public function resolve(string $URL, string $method)
    {
        $route = explode('?', $URL)[0];
        $action = $this->routes[$route][$method] ?? null;

        if (!$action) {
            throw new NotFoundException();
        }

        if (!is_array($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $classMethod] = $action;

            if (class_exists($class)) {
                $class = new $class;

                if (method_exists($class, $classMethod)) {
                    return call_user_func_array([$class, $classMethod], []);
                }
            }
        }

        throw new NotFoundException();
    }
}
