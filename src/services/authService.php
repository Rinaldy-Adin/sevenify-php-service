<?php

namespace services;

require_once ROOT_DIR . 'repositories/userRepository.php';

use repositories\UserRepository;

class AuthService {
    private UserRepository $userRepo;

    function __construct() {
        $this->userRepo = new UserRepository();
    }

    //return [user, message]
    function login(string $username, string $password) : array {
        $user = $this->userRepo->getUserByUsername($username);

        if ($user == null) {
            return [null, "User not found"];
        }

        if (!password_verify($password, $user->user_password)) {
            return [null, "Username and password does not match"];
        }

        return [$user, "Login successful"];
    }
}