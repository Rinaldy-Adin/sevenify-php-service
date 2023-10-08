<?php
require_once ROOT_DIR . 'models/albumModel.php';
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'models/playlistModel.php';
require_once ROOT_DIR . 'repositories/musicRepository.php';
require_once ROOT_DIR . 'repositories/albumRepository.php';
require_once ROOT_DIR . 'repositories/playlistRepository.php';
require_once ROOT_DIR . 'public/views/components/musicList.php';
require_once ROOT_DIR . 'public/views/components/albumList.php';
require_once ROOT_DIR . 'public/views/components/playlistList.php';

use models\MusicModel;
use repositories\MusicRepository;
use models\AlbumModel;
use repositories\AlbumRepository;
use models\PlaylistModel;
use repositories\PlaylistRepository;

$musicRepository = new MusicRepository();
$albumRepository = new AlbumRepository();
$playlistRepository = new PlaylistRepository();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/music-bar.css">
    <link rel="stylesheet" href="/public/styles/music-list.css">
    <link rel="stylesheet" href="public/styles/album-list.css">
    <link rel="stylesheet" href="public/styles/playlist-list.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <section id="section-album">
        <?php require ROOT_DIR . '/public/views/components/albumList.php'; ?>
    </section>

    <section id="section-playlist">
        <?php require ROOT_DIR . '/public/views/components/playlistList.php'; ?>
    </section>

    <section id="section-music">
        <?php require ROOT_DIR . '/public/views/components/musicList.php'; ?>
    </section>

    <script src="public/javascript/adios.js"></script>
    <script src="public/javascript/music-bar.js"></script>
    <script src="/public/javascript/music-list.js"></script>
    <script src="/public/javascript/album-list.js"></script>
    <script src="/public/javascript/playlist-list.js"></script>

</body>

</html>