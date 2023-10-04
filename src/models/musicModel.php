<?php

namespace models;
require_once ROOT_DIR . 'models/model.php';

use Model;

class MusicModel extends Model {
    public $music_id;
    public $music_name;
    public $music_owner;
    public $music_duration;
    public $music_audio_path;
    public $music_genre;
    public $album_id;

    public function __construct(
        $music_id,
        $music_name,
        $music_owner,
        $music_duration,
        $music_audio_path,
        $music_genre,
        $album_id
    ) {
        $this->music_id = $music_id;
        $this->music_name = $music_name;
        $this->music_owner = $music_owner;
        $this->music_duration = $music_duration;
        $this->music_audio_path = $music_audio_path;
        $this->music_genre = $music_genre;
        $this->album_id = $album_id;
    }
}