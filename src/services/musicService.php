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

    function getByMusicId(string $musicId): ?MusicModel
    {
        return $this->musicRepo->getByMusicId($musicId);
    }

    function getAudioPathByMusicId(string $musicId): ?string
    {
        return $this->musicRepo->getAudioPathByMusicId($musicId);
    }

    function getCoverPathByMusicId(string $musicId): ?string
    {
        return $this->musicRepo->getCoverPathByMusicId($musicId);
    }

    function searchMusic(string $searchValue, int $page): array
    {
        return $this->musicRepo->searchMusic($searchValue, $page);
    }

    function createMusic(int $user_id, string $title, string $genre, array $musicFile, ?array $coverFile): ?MusicModel
    {
        $music = $this->musicRepo->createMusic($title, $user_id, $genre, $musicFile, $coverFile);

        return $music;
    }
}
