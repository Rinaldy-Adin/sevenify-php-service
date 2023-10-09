<?php

namespace controllers\user;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/userService.php';

use common\Response;
use services\UserService;

// TODO: handle duplicate username

class UpdateUserController
{
    function post(): string
    {
        $userId = $_SESSION['user_id'];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $userModel = UserService::getInstance()->updateUser($userId, $username, $password);
        if ($userModel !== null) {
            return (new Response($userModel->toDTOwithoutPass()))->httpResponse();
        } else {
            http_response_code(500);
            return (new Response(['message' => 'Error updating user'], 500))->httpResponse();
        }
    }
}
