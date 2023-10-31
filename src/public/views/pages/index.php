<?php

require_once ROOT_DIR . 'models/albumModel.php';
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'models/playlistModel.php';
require_once ROOT_DIR . 'repositories/musicRepository.php';
require_once ROOT_DIR . 'repositories/albumRepository.php';
require_once ROOT_DIR . 'repositories/playlistRepository.php';
require_once ROOT_DIR . 'middlewares/authMiddleware.php';

use middlewares\AuthMiddleware;
use repositories\MusicRepository;
use repositories\AlbumRepository;
use repositories\PlaylistRepository;

AuthMiddleware::getInstance()->authUser();
$musicRepository = MusicRepository::getInstance();
$albumRepository = AlbumRepository::getInstance();
$playlistRepository = PlaylistRepository::getInstance();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/homepage.css">
    <link rel="stylesheet" href="/public/styles/music-bar.css">
    <link rel="stylesheet" href="/public/styles/nav-bar.css">
    <link rel="stylesheet" href="/public/styles/music-list.css">
    <link rel="stylesheet" href="public/styles/album-list.css">
    <link rel="stylesheet" href="public/styles/playlist-list.css">
    <link rel="stylesheet" href="public/styles/premium-users-list.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/nav-bar.php'; ?>
    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <div class="container">
        <div class="main-content">
            <section id="section-music">
                <h2>Your Musics</h2>
                <div id="music-list"></div>
                <div id="pagination-music"></div>

                <script src="/public/javascript/music-list.js"></script>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        displayMusic(<?php echo $_SESSION["user_id"]; ?>);
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
                        displayAlbums(<?php echo $_SESSION["user_id"]; ?>);
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
                        displayPlaylists(<?php echo $_SESSION["user_id"]; ?>);
                    });
                </script>
            </section>
        </div>
        
        <div class="side-content">
            <section id="section-premium-users">
                <h2>Premium Users</h2>
                <div class="premium-users" id="premium-users">
                    <div class="premium-users-item">
                        <div class="premium-users-detail">
                            <div class="premium-users-img"></div>
                            <div class="premium-users-name">Artist name</div>
                        </div>
                        <a class="see-artist-button" href="#">
                            See Artist
                        </a>
                    </div>

                    <div class="premium-users-item">
                        <div class="premium-users-detail">
                            <div class="premium-users-img"></div>
                            <div class="premium-users-name">Artist name</div>
                        </div>
                        <a class="see-artist-button" href="#">
                            See Artist
                        </a>
                    </div>
                </div>
    
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        displayPlaylists(<?php echo $_SESSION["user_id"]; ?>);
                    });
                </script>
            </section>
        </div>
    </div>

    <script src="public/javascript/adios.js"></script>
    <script src="public/javascript/music-bar.js"></script>
    <script src="/public/javascript/music-list.js"></script>
    <script src="/public/javascript/album-list.js"></script>
    <script src="/public/javascript/playlist-list.js"></script>

</body>

</html>