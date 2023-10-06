<?php
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'public/views/components/musicItem.php';

use models\MusicModel;

$music = new MusicModel(1, "Dua-dua", "Igditaf", "Pop");
$showMusic = musicItem($music);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Sevenify</title>
    <link rel="stylesheet" type="text/css" href="/public/styles/musicItem.css">
</head>

<body>
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

    <!-- <script src="src\public\javascript\homepage.js"></script> -->
</body>

</html>