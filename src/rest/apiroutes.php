<?php

namespace rest;

require_once ROOT_DIR . 'controllers/auth/loginController.php';
require_once ROOT_DIR . 'controllers/auth/registerController.php';

use controllers\auth\LoginController;
use controllers\auth\RegisterController;

class APIRoutes
{
    public static array $apiroutes = [
        ['/api/login', 'post', LoginController::class],
        ['/api/register', 'post', RegisterController::class]
    ];
}
