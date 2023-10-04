<?php

namespace models;
require_once ROOT_DIR . 'models/model.php';

use Model;

class PlaylistModel extends Model {
    public $playlist_id;
    public $playlist_name;
    public $playlist_owner;
    public $playlist_cover_path;

    public function __construct(
        $playlist_id,
        $playlist_name,
        $playlist_owner,
        $playlist_cover_path
    ) {
        $this->playlist_id = $playlist_id;
        $this->playlist_name = $playlist_name;
        $this->playlist_owner = $playlist_owner;
        $this->playlist_cover_path = $playlist_cover_path;
    }
}