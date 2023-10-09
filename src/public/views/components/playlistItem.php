<?php

require_once ROOT_DIR . '/models/playlistModel.php';
require_once ROOT_DIR . '/repositories/playlistRepository.php';
require_once ROOT_DIR . '/repositories/playlistRepository.php';

use models\PlaylistModel;
use repositories\PlaylistRepository;
use repositories\UserRepository;

function playlistItem($playlist){
    $playlist_id = $playlist->playlist_id;
    $playlist_name = $playlist->playlist_name;
    $playlist_owner = $playlist->playlist_owner;
    $playlist_cover_path = $playlist->playlist_cover_path;

    $html = <<< "EOT"
    <div class="container-playlist" onclick="">
        <div class="image-box id="image-playlist">
            <img src="$playlist_cover_path" alt="Cover Image">
        </div>
        <div class="playlist-text">
            <div class="category-playlist">Playlist</div>
            <div class="playlist-title">$playlist_name</div>
        </div>
    </div>
    EOT;
    return $html;
}
?>