<?php
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'public/views/components/musicItem.php';

use models\MusicModel;

$music = new MusicModel(1, "Dua-dua", "Igditaf", "Pop");
$showMusic = musicItem($music);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/styles/global.css">
    <link rel="stylesheet" href="public/styles/music-bar.css">
    <title>Sevenify</title>
</head>

<body>
    <h1>hi</h1>

    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>
    
    <section id="section-album">
        <h2>Your Albums</h2>
    </section>

    <section id="section-playlist">
        <h2>Your Playlists</h2>
    </section>

    <section id="section-music">
        <h2>Your Musics</h2>
        <?php
            echo $showMusic;
        ?>
    </section>

    <script src="public/javascript/adios.js"></script>
    <script src="public/javascript/music-bar.js"></script>
    <script src="/public/javascript/music-item.js"></script>

</body>

</html>