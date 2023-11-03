<?php
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'repositories/musicRepository.php';
require_once ROOT_DIR . 'repositories/albumRepository.php';
require_once ROOT_DIR . 'services/albumService.php';
require_once ROOT_DIR . 'services/userService.php';
require_once ROOT_DIR . 'middlewares/authMiddleware.php';

use middlewares\AuthMiddleware;
use services\AlbumService;

AuthMiddleware::getInstance()->authUser();
$albumService = AlbumService::getInstance();

$uri = $_SERVER['REQUEST_URI'];
$pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

if (!is_numeric($pathEntries[count($pathEntries) - 1])) {
    header('Location: /404');
} else {
    $album_id = (int)$pathEntries[count($pathEntries) - 1];
    $album = $albumService->getByAlbumIdName($album_id);

    if ($album == null) {
        header('Location: /404');
    }
}

$coverPath = $albumService->getCoverPathByAlbumId($album_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/music-bar.css">
    <link rel="stylesheet" href="/public/styles/nav-bar.css">
    <link rel="stylesheet" href="/public/styles/album-music-list.css">
    <title>Sevenify : Album</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>
    <?php require ROOT_DIR . 'public/views/components/nav-bar.php'; ?>

    <div class="container">
        <section id="album-music">
            <div class="album-cover">
                <img id="album-cover-img" src="/api/album-cover/<?php echo $album_id; ?>" alt="Playlist Cover">
            </div>
            <div class="album-name">
                <?= $album[0]->album_name ?>
            </div>
            <div class="album-owner">
                Owner: <?= $album[0]->album_owner_name ?>
            </div>
            <a href="/album/update-album/<?php echo $album_id; ?>" class="update-album-link">Update Album</a>
        </section>

        <section id="album-music-list">
            <h2>Album's Music</h2>
            <div id="album-music-item"></div>
            <div id="pagination-album-music"></div>
        </section>
    </div>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/music-bar.js"></script>
    <script src="/public/javascript/album-music-list.js"></script>

    <script>
        displayAlbumMusic(<?php echo $album_id; ?>);
    </script>

</body>

</html>