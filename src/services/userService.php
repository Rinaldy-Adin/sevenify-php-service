<?php

namespace services;

require_once ROOT_DIR . 'models/userModel.php';
require_once ROOT_DIR . 'repositories/userRepository.php';

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

    function register(string $username, string $password, bool $isAdmin = false): array
    {
        $user = $this->userRepo->getUserByUsername($username);

        if ($user !== null) {
            return [400, "Username already used"];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = $this->userRepo->createUser($username, $hashedPassword, $isAdmin);

        if ($user) {
            return [200, "Login successful"];
        } else {
            return [500, "Failed to add user"];
        }
    }

    function updateUser(string $userId, string $username, string $password, ?bool $isAdmin = null): ?UserModel
    {
        $user = $this->userRepo->getUserByUsername($username);

        // TODO: notify duplicate
        if ($user !== null) {
            // return [400, "Username not found"];
            return null;
        }

        if ($password != "")
            $password = password_hash($password, PASSWORD_DEFAULT);
        $user = $this->userRepo->updateUser($userId, $username, $password, $isAdmin);

        return $user;
    }

    function getByUserId(string $musicId): ?UserModel
    {
        return $this->userRepo->getUserById($musicId);
    }

    function getAllUsers(): array
    {
        return $this->userRepo->getAllUsers(null)[0];
    }

    function getAllUsersAdmin(int $page): array
    {
        return $this->userRepo->getAllUsers($page);
    }

    function deleteUser(int $user_id): bool
    {
        return $this->userRepo->deleteUser($user_id);
    }

    // function createMusic(int $user_id, string $title, string $genre, array $musicFile, ?array $coverFile): ?MusicModel
    // {
    //     $music = $this->musicRepo->createMusic($title, $user_id, $genre, $musicFile, $coverFile);

    //     return $music;
    // }
}
