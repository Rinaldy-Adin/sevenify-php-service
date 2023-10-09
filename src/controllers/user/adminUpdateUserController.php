<?php

namespace controllers\user;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/userService.php';

use common\Response;
use services\UserService;

// TODO: handle duplicate username

class AdminUpdateUserController
{
    function post(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $userId = $pathEntries[count($pathEntries) - 1];

        $username = $_POST["username"];
        $password = $_POST["password"];
        $is_admin = isset($_POST["is-admin"]) ? true : false;

        $userModel = UserService::getInstance()->updateUser($userId, $username, $password, $is_admin);
        return (new Response($userModel->toDTO()))->httpResponse();
    }
}
