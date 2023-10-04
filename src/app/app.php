<?php

namespace app;

require_once ROOT_DIR . 'routers/pageRouter.php';
require_once ROOT_DIR . 'exceptions/NotFoundException.php';
require_once ROOT_DIR . 'exceptions/NotFoundException.php';
require_once ROOT_DIR . 'rest/apiroutes.php';

use router\APIRouter;
use router\PageRouter;
use rest\APIRoutes;

class App
{
    function run()
    {
        if (strlen($_SERVER['REQUEST_URI']) > 4 && substr($_SERVER['REQUEST_URI'], 0, 5) == '/api/') {
            $router = new APIRouter();

            foreach (APIRoutes::$apiroutes as $idx => $route) {
                $router->register(...$route);
            }

            $request_uri = $_SERVER['REQUEST_URI'];
            $method = strtolower($_SERVER['REQEST_METHOD']);
            echo $router->resolve($request_uri, $method);
        } else {
            $router = new PageRouter('/404');
            $request_uri = $_SERVER['REQUEST_URI'];

            echo $router->resolve($request_uri);
        }
    }
}
