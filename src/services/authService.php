<?php

namespace services;

require_once ROOT_DIR . 'repositories/userRepository.php';

use repositories\UserRepository;

class AuthService
{
    private UserRepository $userRepo;

    function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    function login(string $username, string $password): array
    {
        $user = $this->userRepo->getUserByUsername($username);

        if ($user == null) {
            return [null, "User not found"];
        }

        if (!password_verify($password, $user->user_password)) {
            return [null, "Username and password does not match"];
        }

        return [$user, "Login successful"];
    }

    function register(string $username, string $password): array
    {
        $user = $this->userRepo->getUserByUsername($username);

        if ($user !== null) {
            return [400, "Username already used"];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = $this->userRepo->createUser($username, $hashedPassword);

        if ($user) {
            return [200, "Login successful"];
        } else {
            return [500, "Failed to add user"];
        }
    }
}
