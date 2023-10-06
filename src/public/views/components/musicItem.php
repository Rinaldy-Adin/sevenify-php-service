<?php

require_once ROOT_DIR . '/models/musicModel.php';

use models\MusicModel;

function musicItem($music){
    $music_id = $music->music_id;
    $music_name = $music->music_name;
    $music_owner = $music->music_owner;
    $music_genre = $music->music_genre;

    $html = <<< "EOT"
    <link rel="stylesheet" type="text/css" href="/public/styles/musicItem.css">
    <script src="/public/javascript/music-item.js"></script>

    <div class="music-item">
        <div class="play-button">
            <img src="/public/assets/media/PlayButton.png" alt="Play">
        </div>
        <div class="music-cover">
            <img src="/public/assets/media/contohcovermusic.jpg" alt="Cover Image">
        </div>
        <div class="music-details">
            <span class="owner">$music_owner :</span>
            <span class="name">$music_name</span>
        </div>
        <div class="music-option">
            <button class = "option-button" onclick="toggleOptionsMenu(event)">
                <img src="/public/assets/media/EditButton.png" alt="Option Menu">
            </button>
            <div class="option-menu" id="optionsMenu">
                <button class="edit-button" alt="Edit music">Edit</button>
                <button class="delete-button" alt="Delete music">Delete</button>
            </div>
        </div>
    </div>
    EOT;
    return $html;
}

// Testing
// echo MusicItem(new MusicModel(1, "Dua-dua", "Igditaf", "Pop"));
?>
