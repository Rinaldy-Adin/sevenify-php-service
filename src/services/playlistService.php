<?php

namespace services;

require_once ROOT_DIR . 'models/playlistModel.php';
require_once ROOT_DIR . 'repositories/playlistRepository.php';
require_once ROOT_DIR . 'repositories/userRepository.php';

use models\PlaylistModel;
use repositories\PlaylistRepository;
use repositories\UserRepository;

class PlaylistService{
    private PlaylistRepository $playlistRepo;
    function __construct()
    {
        $this->playlistRepo = new PlaylistRepository();
    }
    function getByUserID(int $userId, int $page) : array
    {
        return $this->playlistRepo->getByUserId($userId, $page);
    }

    function getCoverPathByPlaylistId(string $playlistId): ?string
    {
        return $this->playlistRepo->getCoverPathByPlaylistId($playlistId);
    }
}
?>