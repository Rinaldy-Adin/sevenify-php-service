<?php

namespace models;
use Model;

class PlaylistMusicModel extends Model {
    public $music_id;
    public $playlist_id;

    public function __construct($music_id, $playlist_id) {
        $this->music_id = $music_id;
        $this->playlist_id = $playlist_id;
    }
}