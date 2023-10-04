<?php

namespace services;
use models\MusicModel;

class MusicService {
    public $musicRepo;

    function __construct() {
        $musicRepo = new MusicRepo();
    }

    function getByMusicId(string $musicId) : MusicModel {
        return $this->musicRepo->getByMusicId($musicId);
    }
}