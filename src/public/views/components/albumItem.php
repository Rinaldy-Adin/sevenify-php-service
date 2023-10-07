<?php

require_once ROOT_DIR . '/models/albumModel.php';
require_once ROOT_DIR . '/repositories/albumRepository.php';
require_once ROOT_DIR . '/repositories/userRepository.php';

use models\AlbumModel;
use repositories\AlbumRepository;
use repositories\UserRepository;

function albumItem($album){
    $album_id = $album->album_id;
    $album_name = $album->album_name;
    $album_owner = $album->album_owner;
    $album_cover_path = $album->album_cover_path;

    $html = <<< "EOT"
    <div class="container" onclick="">
        <div class="image-box">
            <img src="/public/assets/media/contohcovermusic.jpg" alt="Cover Image">
        </div>
        <div class="album-text">
            <div class="category-album">Album</div>
            <div class="album-title">$album_name</div>
        </div>
    </div>
    EOT;
    return $html;
}
?>