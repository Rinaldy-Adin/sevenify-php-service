<?php

namespace models;

require_once ROOT_DIR . 'models/model.php';

use Model;

class MusicModel extends Model
{
    public $music_id;
    public $music_name;
    public $music_owner;
    public $music_genre;

    public function __construct(
        $music_id,
        $music_name,
        $music_owner,
        $music_genre
    ) {
        $this->music_id = $music_id;
        $this->music_name = $music_name;
        $this->music_owner = $music_owner;
        $this->music_genre = $music_genre;
    }

    public function arrToMusicModel($arr){
        $this->music_id = $arr['music_id'];
        $this->music_name = $arr['music_name'];
        $this->music_owner = $arr['music_owner'];
        $this->music_genre = $arr['music_genre'];
        return $this;
    }
}
