<?php

namespace app;

require_once ROOT_DIR . 'routers/pageRouter.php';
require_once ROOT_DIR . 'exceptions/NotFoundException.php';

use router\PageRouter;


class App
{
    function run()
    {
        if (strlen($_SERVER['REQUEST_URI']) > 4 && substr($_SERVER['REQUEST_URI'], 0, 5) == '/api/') {
            
        } else {
            $router = new PageRouter('/404');
            $request_uri = $_SERVER['REQUEST_URI'];

            echo $router->resolve($request_uri);
        }
    }
}
