<?php

namespace services;

require_once ROOT_DIR . 'models/userModel.php';
require_once ROOT_DIR . 'repositories/userRepository.php';

use exceptions\BadRequestException;
use exceptions\UnauthenticatedException;
use models\UserModel;
use repositories\UserRepository;

class UserService
{
    private static $instance;

    // Static method to get the singleton instance
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private UserRepository $userRepo;

    protected function __construct()
    {
        $this->userRepo = userRepository::getInstance();
    }

    function login(string $username, string $password): UserModel
    {
        $user = $this->userRepo->getUserByUsername($username);

        if ($user == null) {
            throw new UnauthenticatedException("Username not found");
        }

        if (!password_verify($password, $user->user_password)) {
            throw new UnauthenticatedException("Username and password do not match");
        }

        return $user;
    }

    function register(string $username, string $password, bool $isAdmin = false): void
    {
        if ($this->userRepo->getUserByUsername($username)) {
            throw new BadRequestException("Username already used");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userRepo->createUser($username, $hashedPassword, $isAdmin);
    }

    function updateUser(string $userId, string $username, string $password, ?bool $isAdmin = null): UserModel
    {
        if ($this->userRepo->getUserByUsername($username)) {
            throw new BadRequestException("Username already used");
        }

        if ($password != "")
            $password = password_hash($password, PASSWORD_DEFAULT);

        return $this->userRepo->updateUser($userId, $username, $password, $isAdmin);
    }

    function getByUserId(string $musicId): ?UserModel
    {
        return $this->userRepo->getUserById($musicId);
    }

    function getAllUsers(): array
    {
        return $this->userRepo->getAllUsers(null)[0];
    }

    function getAllUsersPaged(int $page): array
    {
        return $this->userRepo->getAllUsers($page);
    }

    function deleteUser(int $user_id): void
    {
        if (!$this->userRepo->getUserById($user_id)) {
            throw new BadRequestException("Username already used");
        }
        
        $this->userRepo->deleteUser($user_id);
    }
}
