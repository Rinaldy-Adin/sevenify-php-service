<?php

namespace app;

require_once ROOT_DIR . 'routers/pageRouter.php';
require_once ROOT_DIR . 'routers/apiRouter.php';
require_once ROOT_DIR . 'exceptions/ForbiddenException.php';
require_once ROOT_DIR . 'exceptions/NotFoundException.php';
require_once ROOT_DIR . 'exceptions/UnauthenticatedException.php';

use common\Response;
use Exception;
use exceptions\AppException;
use PDO;
use router\APIRouter;
use router\PageRouter;
use exceptions\ForbiddenException;
use exceptions\NotFoundException;
use exceptions\UnauthenticatedException;

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
            try {
                $router = APIRouter::getInstance();

                $request_uri = $_SERVER['REQUEST_URI'];
                $method = strtolower($_SERVER['REQUEST_METHOD']);
                echo $router->resolve($request_uri, $method);
            } catch (AppException $e) {
                echo (new Response(["message" => $e->getMessage()], $e->getCode()))->httpResponse();
            } catch (Exception $e) {
                echo (new Response(["message" => "Internal server error"], 500))->httpResponse();
            }
        } else {
            try {
                $router = PageRouter::getInstance();
                $request_uri = $_SERVER['REQUEST_URI'];

                echo $router->resolve($request_uri);
            } catch (ForbiddenException $e) {
                http_response_code($e->getCode());
                header('Location: /');
            } catch (NotFoundException $e) {
                http_response_code($e->getCode());
                header('Location: /404');
            } catch (UnauthenticatedException $e) {
                http_response_code($e->getCode());
                header('Location: /login');
            } catch (Exception $e) {
                http_response_code(500);
                header('Location: /');
            }
        }
    }
}
