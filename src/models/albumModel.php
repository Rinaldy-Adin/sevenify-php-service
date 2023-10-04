<?php

namespace models;
require_once ROOT_DIR . 'models/model.php';

use Model;

class AlbumModel extends Model {
    public $album_id;
    public $album_name;
    public $album_owner;
    public $album_cover_path;

    public function __construct(
        $album_id,
        $album_name,
        $album_owner,
        $album_cover_path
    ) {
        $this->album_id = $album_id;
        $this->album_name = $album_name;
        $this->album_owner = $album_owner;
        $this->album_cover_path = $album_cover_path;
    }
}