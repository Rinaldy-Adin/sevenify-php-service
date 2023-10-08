<?php

namespace services;

require_once ROOT_DIR . 'models/albumModel.php';
require_once ROOT_DIR . 'repositories/albumRepository.php';
require_once ROOT_DIR . 'repositories/userRepository.php';

use models\AlbumModel;
use repositories\AlbumRepository;
use repositories\UserRepository;

class AlbumService{
    private AlbumRepository $albumRepo;
    function __construct()
    {
        $this->albumRepo = new AlbumRepository();
    }
    function getByUserID(int $userId, int $page) : array
    {
        return $this->albumRepo->getByUserId($userId, $page);
    }

    function getCoverPathByAlbumId(string $albumId): ?string
    {
        return $this->albumRepo->getCoverPathByAlbumId($albumId);
    }
}
?>