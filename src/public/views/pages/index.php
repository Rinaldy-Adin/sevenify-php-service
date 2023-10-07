<?php
require_once ROOT_DIR . 'models/albumModel.php';
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'repositories/musicRepository.php';
require_once ROOT_DIR . 'repositories/albumRepository.php';
require_once ROOT_DIR . 'public/views/components/musicItem.php';
require_once ROOT_DIR . 'public/views/components/musicList.php';
require_once ROOT_DIR . 'public/views/components/albumItem.php';
require_once ROOT_DIR . 'public/views/components/albumList.php';

use models\MusicModel;
use repositories\MusicRepository;
use models\AlbumModel;
use repositories\AlbumRepository;

$musicRepository = new MusicRepository();
$albumRepository = new AlbumRepository();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/styles/global.css">
    <link rel="stylesheet" href="public/styles/music-bar.css">
    <link rel="stylesheet" href="public/styles/music-item.css">
    <link rel="stylesheet" href="public/styles/music-list.css">
    <link rel="stylesheet" href="public/styles/album-item.css">
    <link rel="stylesheet" href="public/styles/album-list.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <section id="section-album">
        <?php require ROOT_DIR . '/public/views/components/albumList.php'; ?>
    </section>

    <section id="section-playlist">
        <h2>Your Playlists</h2>
    </section>

    <section id="section-music">
        <?php require ROOT_DIR . '/public/views/components/musicList.php'; ?>
    </section>

    <script src="public/javascript/adios.js"></script>
    <script src="public/javascript/music-bar.js"></script>
    <script src="/public/javascript/music-item.js"></script>
    <script src="/public/javascript/music-list.js"></script>
    <script src="/public/javascript/album-list.js"></script>

</body>

</html>