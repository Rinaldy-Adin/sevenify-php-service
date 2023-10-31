<?php

namespace services;

require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'repositories/musicRepository.php';
require_once ROOT_DIR . 'repositories/userRepository.php';
require_once ROOT_DIR . 'exceptions/BadRequestException.php';
require_once ROOT_DIR . 'exceptions/ForbiddenException.php';

use exceptions\BadRequestException;
use exceptions\ForbiddenException;
use models\MusicModel;
use repositories\MusicRepository;
use repositories\UserRepository;

class MusicService
{
    private MusicRepository $musicRepo;
    private UserRepository $userRepo;

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
        $this->musicRepo = MusicRepository::getInstance();
        $this->userRepo = UserRepository::getInstance();
    }
    
    function getByUserID(int $userId, int $page) : array
    {
        return $this->musicRepo->getByUserId($userId, $page);
    }
    function getByAlbumId(int $albumId, int $page) : array
    {
        return $this->musicRepo->getByAlbumId($albumId, $page);
    }
    function getByPlaylistID(int $playlistId, int $page) : array
    {
        return $this->musicRepo->getByPlaylistId($playlistId, $page);
    }
    
    function getAllMusic(int $page) : array{
        $searchValue = '';
        $genre = 'all';
        $uploadPeriod = 'all-time';
        $sort = '';
        return $this->searchMusic($searchValue, $page, $genre, $uploadPeriod, $sort);
    }

    function deleteMusic(int $musicId) : void {
        if (!$this->getMusicById($musicId))
            throw new BadRequestException("Music id does not exist");

        $this->musicRepo->deleteMusic($musicId);
    }

    function countAllMusic() {
        return $this->musicRepo->countAllMusic();
    }

    function countMusicBy($where=[]) : int
    {
        return $this->musicRepo->countMusicBy($where);
    }
    function getMusicById(string $musicId): ?MusicModel
    {
        return $this->musicRepo->getMusicById($musicId);
    }

    function getAudioPathByMusicId(string $musicId): ?string
    {
        return $this->musicRepo->getAudioPathByMusicId($musicId);
    }

    function getCoverPathByMusicId(string $musicId): ?string
    {
        return $this->musicRepo->getCoverPathByMusicId($musicId);
    }

    function searchMusic(string $searchValue, int $page, string $genre, string $uploadPeriod, string $sort): array
    {
        return $this->musicRepo->searchMusic($searchValue, $page, $genre, $uploadPeriod, $sort);
    }

    function getAllGenres(): array {
        return $this->musicRepo->getAllGenres();
    }

    function createMusic(int $user_id, string $title, string $genre, array $musicFile, ?array $coverFile): MusicModel
    {
        return $this->musicRepo->createMusic($title, $user_id, $genre, $musicFile, $coverFile);
    }

    function updateMusic(int $musicId, int $user_id, string $title, string $genre, bool $deleteCover, ?array $coverFile): MusicModel
    {
        $music = $this->getMusicById(intval($musicId));
        $user = $this->userRepo->getUserById($user_id);

        if (!$music)
            throw new BadRequestException("Music id does not exist");

        if (!$user)
            throw new BadRequestException("User does not exist");

        if ($music->music_owner != $user_id && $user->role != 'admin')
            throw new ForbiddenException("Music not owned by user");

        return $this->musicRepo->updateMusic($musicId, $title, $user_id, $genre, $deleteCover, $coverFile);
    }
}
?>