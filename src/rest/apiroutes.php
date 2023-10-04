<?php

namespace rest;

require_once ROOT_DIR . 'controllers/auth/loginController.php';

use controllers\auth\LoginController;

class APIRoutes {
    public static array $apiroutes = [
        ['/api/login', 'post', LoginController::class]
    ];
}