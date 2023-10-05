<?php

namespace app;

require_once ROOT_DIR . 'routers/pageRouter.php';
require_once ROOT_DIR . 'routers/apiRouter.php';
require_once ROOT_DIR . 'exceptions/NotFoundException.php';
require_once ROOT_DIR . 'exceptions/NotFoundException.php';
require_once ROOT_DIR . 'rest/apiroutes.php';

use PDO;
use router\APIRouter;
use router\PageRouter;
use rest\APIRoutes;

class App
{
    private static ?PDO $db = null;

    static function getDB(): PDO
    {
        if (!static::$db) {
            $connectionString = 'mysql:host=' . $_ENV['MYSQL_HOST'] . ';port=3306;dbname=' . $_ENV['MYSQL_DATABASE'];
            static::$db = new PDO($connectionString, $_ENV['MYSQL_USERNAME'], $_ENV['MYSQL_PASSWORD'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return static::$db;
    }

    function run()
    {
        if (strlen($_SERVER['REQUEST_URI']) > 4 && substr($_SERVER['REQUEST_URI'], 0, 5) == '/api/') {
            $router = new APIRouter();

            foreach (APIRoutes::$apiroutes as $idx => $route) {
                $router->register(...$route);
            }

            $request_uri = $_SERVER['REQUEST_URI'];
            $method = strtolower($_SERVER['REQUEST_METHOD']);
            echo $router->resolve($request_uri, $method);
        } else {
            $router = new PageRouter('/404', ['/login', '/register']);
            $request_uri = $_SERVER['REQUEST_URI'];

            echo $router->resolve($request_uri);
        }
    }
}
