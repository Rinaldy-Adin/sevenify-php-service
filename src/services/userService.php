<?php

namespace services;

require_once ROOT_DIR . 'models/userModel.php';
require_once ROOT_DIR . 'repositories/userRepository.php';

use models\UserModel;
use repositories\UserRepository;

class UserService
{
    private UserRepository $userRepo;

    function __construct()
    {
        $this->userRepo = new userRepository();
    }

    function getByUserId(string $musicId): ?UserModel
    {
        return $this->userRepo->getUserById($musicId);
    }

    function getAllUsers(): array {
        return $this->userRepo->getAllUsers();
    }

    // function createMusic(int $user_id, string $title, string $genre, array $musicFile, ?array $coverFile): ?MusicModel
    // {
    //     $music = $this->musicRepo->createMusic($title, $user_id, $genre, $musicFile, $coverFile);

    //     return $music;
    // }
}
