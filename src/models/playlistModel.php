<?php

namespace models;
require_once ROOT_DIR . 'models/model.php';


class PlaylistModel extends Model {
    public $playlist_id;
    public $playlist_name;
    public $playlist_owner;

    public function __construct(
        $playlist_id,
        $playlist_name,
        $playlist_owner
    ) {
        $this->playlist_id = $playlist_id;
        $this->playlist_name = $playlist_name;
        $this->playlist_owner = $playlist_owner;
    }
}