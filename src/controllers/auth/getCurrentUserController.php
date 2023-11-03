<?php

namespace controllers\auth;

require_once ROOT_DIR . 'services/userService.php';
require_once ROOT_DIR . 'common/response.php';

use common\Response;
use services\UserService;

class GetCurrentUserController
{
    function get(): string
    {
        $userId = $_SESSION['user_id'];

        $user = UserService::getInstance()->getByUserId($userId);
        if ($user) {
            return (new Response($user->toDTOwithoutPass()))->httpResponse();
        } else {
            return (new Response(['message' => 'User not found'], 404))->httpResponse();
        }
    }
}
