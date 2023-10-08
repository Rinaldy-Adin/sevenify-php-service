<?php

require_once ROOT_DIR . '/models/musicModel.php';
require_once ROOT_DIR . '/repositories/musicRepository.php';
require_once ROOT_DIR . '/repositories/userRepository.php';

use models\MusicModel;
use repositories\MusicRepository;
use repositories\UserRepository;

function musicItem($music){
    $music_id = $music->music_id;
    $music_name = $music->music_name;
    $music_owner = $music->music_owner;
    $userRepo = UserRepository::getInstance();
    $owner = $userRepo->getUserById($music_owner);
    $owner_name = $owner->user_name;

    $html = <<< "EOT"
    <div class="music-item">
        <div class="play-button" onclick="playMusic($music_id)">
            <img src="/public/assets/media/PlayButton.png" alt="Play">
        </div>
        <div class="music-cover">
            <img src="/api/music-cover/$music_id" alt="Cover Image">
        </div>
        <div class="music-details">
            <span class="owner">$owner_name :</span>
            <span classA="name">$music_name</span>
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
