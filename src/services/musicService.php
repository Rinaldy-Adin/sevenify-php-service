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

    function getAllMusics() {
        return $this->musicRepo->getAllMusics();
    }

    function getMusicById($musicId) {
        return $this->musicRepo->getMusicById($musicId);
    }
    
    function countAllMusic(){
        return $this->musicRepo->countAllMusic();
    }

    function countMusicBy($where=[]){
        return $this->musicRepo->countMusicBy($where);
    }

    function createMusic(int $user_id, string $title, string $genre, array $musicFile, ?array $coverFile): ?MusicModel
    {
        $music = $this->musicRepo->createMusic($title, $user_id, $genre, $musicFile, $coverFile);

        return $music;
    }
}
