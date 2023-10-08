<?php

namespace models;
require_once ROOT_DIR . 'models/model.php';


class AlbumModel extends Model {
    public $album_id;
    public $album_name;
    public $album_owner;

    public function __construct(
        $album_id,
        $album_name,
        $album_owner
    ) {
        $this->album_id = $album_id;
        $this->album_name = $album_name;
        $this->album_owner = $album_owner;
    }
}