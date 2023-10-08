<?php

namespace services;

require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'repositories/musicRepository.php';
require_once ROOT_DIR . 'repositories/userRepository.php';

use models\MusicModel;
use repositories\MusicRepository;
use repositories\UserRepository;

class MusicService
{
    private MusicRepository $musicRepo;

    function __construct()
    {
        $this->musicRepo = new MusicRepository();
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

    function deleteMusic(int $musicId) : bool {
        return $this->musicRepo->deleteMusic($musicId);
    }

    function countAllMusic(){
        return $this->musicRepo->countAllMusic();
    }

    function countMusicBy($where=[]) : ?int
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

    function createMusic(int $user_id, string $title, string $genre, array $musicFile, ?array $coverFile): ?MusicModel
    {
        $music = $this->musicRepo->createMusic($title, $user_id, $genre, $musicFile, $coverFile);

        return $music;
    }

    function updateMusic(int $musicId, int $user_id, string $title, string $genre, bool $deleteCover, ?array $coverFile): ?MusicModel
    {
        $music = $this->musicRepo->updateMusic($musicId, $title, $user_id, $genre, $deleteCover, $coverFile);

        return $music;
    }
}
?>