<?php
    namespace component;

    define("ROOT_DIR", "/mnt/d/PROGRAM_KULIAH/SEMESTER 5/tubes-wbd-1-backup/src/");
    require_once ROOT_DIR . '/models/musicModel.php';
    require_once ROOT_DIR . '/models/musicModel.php';

    use models\MusicModel;

    function musicItem($music){
        $music_id = $music->music_id;
        $music_name = $music->music_name;
        $music_owner = $music->music_owner;
        $music_genre = $music->music_genre;

        $html = <<< "EOT"
        <div class="music-item">
            <div class="music-cover">
                <img src="../../../public/assets/media/contohcovermusic.jpg" alt="Cover Image">
            </div>
            <div class="music-details">
                <div class="music-title">
                    <span class="owner">$music_owner :</span>
                    <span class="name">$music_name</span>
                </div>
                <div class="play-button">
                    <img src="../../../public/assets/media/PlayButton.png" alt="Play Button">
                </div>
            </div>
        </div>
        <link rel="stylesheet" type="text/css" href="../../../public/styles/musicItem.css">

        EOT;
        return $html;
    }

    // Testing
    echo musicItem(new MusicModel(1, "Dua-dua", "Igditaf", "Pop"));
?>