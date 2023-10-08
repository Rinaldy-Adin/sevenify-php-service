<?php

namespace controllers\user;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/userService.php';

use common\Response;
use services\UserService;

class AdminCreateUserController
{
    function post(): string
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $is_admin = isset($_POST["is-admin"]) ? true : false;

        [$statusCode, $message] = UserService::getInstance()->register($username, $password, $is_admin);
        http_response_code($statusCode);
        return (new Response(['message' => $message], $statusCode, []))->httpResponse();
    }
}
