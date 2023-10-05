<?php

namespace rest;

require_once ROOT_DIR . 'controllers/auth/loginController.php';
require_once ROOT_DIR . 'controllers/auth/registerController.php';
require_once ROOT_DIR . 'controllers/music/createMusicController.php';

use controllers\auth\LoginController;
use controllers\auth\RegisterController;
use controllers\music\CreateMusicController;

// TODO: move this to /router

class APIRoutes
{
    public static array $apiroutes = [
        ['/api/login', 'post', LoginController::class],
        ['/api/register', 'post', RegisterController::class],
        ['/api/music', 'post', CreateMusicController::class]
    ];
}
