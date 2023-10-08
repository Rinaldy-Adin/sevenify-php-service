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
    public function getByAlbumIdName(int $albumId) : array
    {
        return $this->albumRepo->getByAlbumIdName($albumId);
    }
}
?><?php

namespace services;

require_once ROOT_DIR . 'models/albumModel.php';
require_once ROOT_DIR . 'repositories/albumRepository.php';

use models\AlbumModel;
use repositories\AlbumRepository;

class AlbumService
{
    private AlbumRepository $albumRepo;

    function __construct()
    {
        $this->albumRepo = new AlbumRepository();
    }

    function getByAlbumId(int $albumId) : AlbumModel {
        return $this->albumRepo->getAlbumById($albumId);
    }

    function getAllAlbums(?int $page) : array {
        return $this->albumRepo->getAllAlbums($page);
    }

    function getAlbumMusic(int $albumId) : array {
        return $this->albumRepo->getAlbumMusic($albumId);
    }

    function getCoverPathByAlbumId(int $albumId): ?string {
        return $this->albumRepo->getCoverPathByAlbumId($albumId);
    }

    function createAlbum(string $title, int $user_id, ?array $coverFile, array $music_ids) :AlbumModel {
        return $this->albumRepo->createAlbum($title, $user_id, $coverFile, $music_ids);
    }

    function updateAlbum(int $album_id, string $title, int $user_id, bool $deleteCover, ?array $coverFile, array $music_ids) :?AlbumModel {
        return $this->albumRepo->updateAlbum($album_id, $title, $user_id, $deleteCover, $coverFile, $music_ids);
    }

    function deleteAlbum(int $albumId): bool {
        return $this->albumRepo->deleteAlbum($albumId);
    }
}