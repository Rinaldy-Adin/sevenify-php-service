<?php

namespace middlewares;

require_once ROOT_DIR . 'exceptions/ForbiddenException.php';
require_once ROOT_DIR . 'exceptions/UnauthenticatedException.php';
require_once ROOT_DIR . 'services/userService.php';

use exceptions\ForbiddenException;
use exceptions\UnauthenticatedException;
use services\UserService;

class AuthMiddleware {
    private static $instance;
    private UserService $userService;

    private function __construct() {
        $this->userService = UserService::getInstance();
    }

    // Static method to get the singleton instance
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function authUnauthenticated() {
        if (isset($_SESSION['user_id'])) {
            throw new ForbiddenException();
        }
        return true;
    }

    public function authUser() {
        if (!isset($_SESSION['user_id'])) {
            throw new UnauthenticatedException();
        }
        return true;
    }

    public function authAdmin() {
        if (!isset($_SESSION['user_id'])) {
            throw new UnauthenticatedException();
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userService->getByUserId($userId);

        if ($user->role != 'admin') {
            throw new ForbiddenException();
        }
        return true;
    }
}