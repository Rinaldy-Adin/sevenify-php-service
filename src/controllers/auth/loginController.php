<?php

namespace controllers\auth;

require_once ROOT_DIR . 'services/authService.php';
require_once ROOT_DIR . 'common/response.php';

use common\Response;
use services\AuthService;

class LoginController {
    function post() : string {
        $username = $_POST["username"];
        $password = $_POST["password"];

        [$user, $message] = (new AuthService())->login($username, $password);
        if ($user) {
            http_response_code(200);
            $_SESSION["user_id"] = $user->user_id;
            return (new Response(['message' => $message], 200, []))->httpResponse();
        } else {
            http_response_code(401);
            return (new Response(['message' => $message], 401))->httpResponse();
        }
    }
}