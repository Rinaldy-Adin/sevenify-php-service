<?php

namespace controllers\auth;

require_once ROOT_DIR . 'services/authService.php';
require_once ROOT_DIR . 'common/response.php';

use common\Response;
use services\AuthService;

class RegisterController
{
    function post(): string
    {
        // TODO: String length validation
        $username = $_POST["username"];
        $password = $_POST["password"];

        [$statusCode, $message] = (new AuthService())->register($username, $password);
        http_response_code($statusCode);
        return (new Response(['message' => $message], $statusCode, []))->httpResponse();
    }
}
