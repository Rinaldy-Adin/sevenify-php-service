<?php

namespace controllers\auth;

require_once ROOT_DIR . 'services/userService.php';
require_once ROOT_DIR . 'common/response.php';

use common\Response;
use services\UserService;

class LoginController
{
    function post(): string
    {
        // TODO: String length validation
        $username = $_POST["username"];
        $password = $_POST["password"];

        [$user, $message] = UserService::getInstance()->login($username, $password);
        $_SESSION["user_id"] = $user->user_id;
        return (new Response(['message' => $message], 200, []))->httpResponse();
    }
}
