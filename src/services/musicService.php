<?php

namespace service;

use models\MusicModel;
use repositories\MusicRepository;

class MusicService extends \Service {
    public $musicRepo;

    function __construct() {
        parent::__construct();
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
}