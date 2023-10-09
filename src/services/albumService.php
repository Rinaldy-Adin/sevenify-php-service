<?php

namespace services;

require_once ROOT_DIR . 'models/albumModel.php';
require_once ROOT_DIR . 'repositories/albumRepository.php';
require_once ROOT_DIR . 'repositories/userRepository.php';
require_once ROOT_DIR . 'exceptions/BadRequestException.php';

use exceptions\BadRequestException;
use exceptions\UnsupportedMediaTypeException;
use models\AlbumModel;
use repositories\AlbumRepository;

class AlbumService
{
    private AlbumRepository $albumRepo;

    private static $instance;

    // Static method to get the singleton instance
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function __construct()
    {
        $this->albumRepo = AlbumRepository::getInstance();
    }

    function getByAlbumId(int $albumId): ?AlbumModel
    {
        return $this->albumRepo->getByAlbumId($albumId);
    }

    function getAllAlbums(?int $page): array
    {
        return $this->albumRepo->getAllAlbums($page);
    }

    function getAlbumMusic(int $albumId): array
    {
        return $this->albumRepo->getAlbumMusic($albumId);
    }

    function getCoverPathByAlbumId(int $albumId): ?string
    {
        return $this->albumRepo->getCoverPathByAlbumId($albumId);
    }

    function createAlbum(string $title, int $user_id, ?array $coverFile, array $music_ids = []): AlbumModel
    {
        

        return $this->albumRepo->createAlbum($title, $user_id, $coverFile, $music_ids);
    }

    function updateAlbum(int $album_id, string $title, int $user_id, bool $deleteCover, ?array $coverFile, array $music_ids): ?AlbumModel
    {
        if (!$this->getByAlbumId($album_id))
            throw new BadRequestException("Album id does not exist");

        return $this->albumRepo->updateAlbum($album_id, $title, $user_id, $deleteCover, $coverFile, $music_ids);
    }

    function deleteAlbum(int $albumId): void
    {
        if (!$this->getByAlbumId($albumId))
            throw new BadRequestException("Album id does not exist");

        $this->albumRepo->deleteAlbum($albumId);
    }
    function getByUserID(int $userId, int $page): array
    {
        return $this->albumRepo->getByUserId($userId, $page);
    }

    function getByAlbumIdName(int $albumId): array
    {
        return $this->albumRepo->getByAlbumIdName($albumId);
    }
}
