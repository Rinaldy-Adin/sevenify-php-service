<?php

namespace controllers\user;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/userService.php';

use common\Response;
use services\UserService;

class DeleteUserController
{
    function delete(): string
    {
        $user_id = (int)$_SESSION['user_id'];

        UserService::getInstance()->deleteUser($user_id);
        unset($_SESSION['user_id']);
        return (new Response(['message' => 'Successfully deleted user']))->httpResponse();
    }
}
