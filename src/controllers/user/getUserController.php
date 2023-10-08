<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/userService.php';

use common\Response;
use services\UserService;

class GetUserController
{
    function get(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $user_id = $pathEntries[count($pathEntries) - 1];

        $userModel = (new UserService())->getByUserId($user_id);
        if ($userModel) {
            return (new Response($userModel->toDTOwithoutPass()))->httpResponse();
        } else {
            return (new Response(['message' => 'User not found'], 400))->httpResponse();
        }
    }
}
