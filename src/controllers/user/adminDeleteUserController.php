<?php

namespace controllers\user;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/userService.php';

use common\Response;
use services\UserService;

class AdminDeleteUserController
{
    function delete(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

        if (!is_numeric($pathEntries[count($pathEntries) - 1]))
            return (new Response(['message' => 'User id invalid'], 400))->httpResponse();

        $user_id = (int)$pathEntries[count($pathEntries) - 1];

        $ok = UserService::getInstance()->deleteUser($user_id);
        if ($ok) {
            return (new Response(['message' => 'Successfully deleted user']))->httpResponse();
        } else {
            http_response_code(500);
            return (new Response(['message' => 'Error deleting user'], 500))->httpResponse();
        }
    }
}
