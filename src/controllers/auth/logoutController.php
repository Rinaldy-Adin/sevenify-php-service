<?php

namespace controllers\auth;

require_once ROOT_DIR . 'services/userService.php';
require_once ROOT_DIR . 'common/response.php';

use common\Response;
use services\UserService;

class LogoutController
{
    function get(): string
    {
        unset($_SESSION['user_id']);
        return (new Response(['message' => "Successfully logged out"]))->httpResponse();
    }
}
