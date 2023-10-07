<?php
require_once ROOT_DIR . 'models/albumModel.php';
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'models/playlistModel.php';
require_once ROOT_DIR . 'repositories/musicRepository.php';
require_once ROOT_DIR . 'repositories/albumRepository.php';
require_once ROOT_DIR . 'public/views/components/musicList.php';
require_once ROOT_DIR . 'public/views/components/albumList.php';
require_once ROOT_DIR . 'public/views/components/playlistItem.php';

use models\MusicModel;
use repositories\MusicRepository;
use models\AlbumModel;
use repositories\AlbumRepository;
use models\PlaylistModel;

$musicRepository = new MusicRepository();
$albumRepository = new AlbumRepository();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/styles/global.css">
    <link rel="stylesheet" href="public/styles/music-bar.css">
    <link rel="stylesheet" href="public/styles/music-list.css">
    <link rel="stylesheet" href="public/styles/album-list.css">
    <link rel="stylesheet" href="public/styles/playlist-item.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <section id="section-album">
        <?php require ROOT_DIR . '/public/views/components/albumList.php'; ?>
    </section>

    <section id="section-playlist">
        <h2>Your Playlists</h2>
        <?php
            $playlist = new PlaylistModel(1, "Playlist1", 1, "/public/assets/placeholders/playlist-placeholder.png");
            echo playlistItem($playlist);
        ?>

    </section>

    <section id="section-music">
        <?php require ROOT_DIR . '/public/views/components/musicList.php'; ?>
    </section>

    <script src="public/javascript/adios.js"></script>
    <script src="public/javascript/music-bar.js"></script>
    <script src="/public/javascript/music-list.js"></script>
    <script src="/public/javascript/album-list.js"></script>

</body>

</html>