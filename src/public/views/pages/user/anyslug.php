<?php

require_once ROOT_DIR . 'services/userService.php';
require_once ROOT_DIR . 'middlewares/authMiddleware.php';

use middlewares\AuthMiddleware;
use services\UserService;

AuthMiddleware::getInstance()->authUser();

$pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
$visited_user = null;

if (!is_numeric($pathEntries[count($pathEntries) - 1])) {
    header('Location: /404');
} else {
    $visited_user_id = $pathEntries[count($pathEntries) - 1];
    $visited_user = UserService::getInstance()->getByUserId($visited_user_id);

    if ($visited_user == null) {
        header('Location: /404');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/user.css">
    <link rel="stylesheet" href="/public/styles/music-bar.css">
    <link rel="stylesheet" href="/public/styles/nav-bar.css">
    <link rel="stylesheet" href="/public/styles/music-list.css">
    <link rel="stylesheet" href="/public/styles/album-list.css">
    <link rel="stylesheet" href="/public/styles/playlist-list.css">
    <link rel="stylesheet" href="/public/styles/premium-users-list.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/nav-bar.php'; ?>
    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <div class="container">
        <section id="section-user">
            <h1><?= $visited_user->user_name ?></h1>
            <button id="follow" class="btn">Follow User</button>
        </section>

        <section id="section-music">
            <h2>Their Music</h2>
            <div id="music-list"></div>
            <div id="pagination-music"></div>

            <script src="/public/javascript/music-list.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    displayMusic(<?= $visited_user->user_id ?>);
                });
            </script>
        </section>

        <section id="section-album">
            <h2>Your Album</h2>
            <a href="/create-album" class="create-album-link">Create Album</a>
            <div id="album-slider"></div>
            <div id="pagination-album"></div>

            <script src="/public/javascript/album-list.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    displayAlbums(<?= $visited_user->user_id ?>);
                });
            </script>
        </section>

        <section id="section-playlist">
            <h2>Your Playlist</h2>
            <a href="/create-playlist" class="create-playlist-link">Create Playlist</a>
            <div class="playlist-slider" id="playlist-slider"></div>
            <div id="pagination-playlist"></div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    displayPlaylists(<?= $visited_user->user_id ?>);
                });
            </script>
        </section>
    </div>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/music-bar.js"></script>
    <script src="/public/javascript/music-list.js"></script>
    <script src="/public/javascript/album-list.js"></script>
    <script src="/public/javascript/playlist-list.js"></script>

</body>

</html>