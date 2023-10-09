<?php

declare(strict_types=1);

namespace router;

require_once ROOT_DIR . 'rest/apiroutes.php';
require_once ROOT_DIR . 'middlewares/authMiddleware.php';
require_once ROOT_DIR . 'exceptions/NotFoundException.php';

use exceptions\NotFoundException;
use middlewares\AuthMiddleware;
use rest\APIRoutes;

class APIRouter
{
    protected array $routes;
    protected AuthMiddleware $authMiddleware;
    private static $instance;
    
    private function __construct() {
        $this->authMiddleware = AuthMiddleware::getInstance();
    }

    // Static method to get the singleton instance
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();

            foreach (APIRoutes::$apiroutes as $route) {
                static::$instance->register(...$route);
            }
        }
        return static::$instance;
    }

    public function register(string $route, string $method, string $controller, string $access = 'user'): void
    {
        $this->routes[$route][$method] = [$controller, $access];
    }

    public function resolve(string $URL, string $method): string
    {
        $route = explode('?', $URL)[0];
        [$controller, $access] = $this->routes[$route][$method] ?? null;

        if (!$controller) {
            $route = explode('/', $route);
            array_pop($route);
            $route = implode('/', $route) . '/*';
            [$controller, $access] = $this->routes[$route][$method] ?? null;
        }
        
        if (!$controller) {
            error_log('controller not found');
            http_response_code(404);
            throw new NotFoundException($URL);
        }
    
        if (class_exists($controller)) {
            $controller = new $controller;

            if ($access == 'user') {
                $this->authMiddleware->authUser();
            } else if ($access == 'admin') {
                $this->authMiddleware->authAdmin();
            } else {
                $this->authMiddleware->authUnauthenticated();
            }

            if (method_exists($controller, $method)) {
                return call_user_func_array([$controller, $method], []);
            }
        }

        error_log('method doesnt exist');
        http_response_code(404);
        throw new NotFoundException($URL);
    }
}
