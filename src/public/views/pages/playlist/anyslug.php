<?php
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'repositories/musicRepository.php';
require_once ROOT_DIR . 'repositories/playlistRepository.php';
require_once ROOT_DIR . 'services/playlistService.php';
require_once ROOT_DIR . 'services/userService.php';

use models\MusicModel;
use repositories\MusicRepository;
use repositories\PlaylistRepository;
use services\UserService;
use services\PlaylistService;

$playlistService = new PlaylistService();

$uri = $_SERVER['REQUEST_URI'];
$pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

if (!is_numeric($pathEntries[count($pathEntries) - 1])) {
    header('Location: /404');
} else {
    $playlist_id = (int)$pathEntries[count($pathEntries) - 1];
    $playlist = $playlistService->getByPlaylistIdName($playlist_id);

    if ($playlist == null) {
        header('Location: /404');
    }
}

$coverPath = $playlistService->getCoverPathByPlaylistId($playlist_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/music-bar.css">
    <link rel="stylesheet" href="/public/styles/playlist-music-list.css">
    <title>Sevenify : Playlist</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <section id="playlist-music">
        <div class="playlist-cover">
            <img src="/api/playlist-cover/<?php echo $playlist_id; ?>" alt="Playlist Cover">
        </div>
        <div class="playlist-name">
            <?= $playlist[0]->playlist_name ?>
        </div>    
        <div class="playlist-owner">
            <?= $playlist[0]->playlist_owner_name ?>
        </div>
        <a href="/playlist/update-playlist/<?php echo $playlist_id; ?>" class="update-playlist-link">Update Playlist</a>
    </section>

    <section id="playlist-music-list">
        <h2>Playlist's Music</h2>
        <div id="playlist-music-item"></div>
        <div id="pagination-playlist-music"></div>
    </section>

    <script src="../../../public/javascript/adios.js"></script>
    <script src="../../../public/javascript/music-bar.js"></script>
    <script src="../../../public/javascript/playlist-music-list.js"></script>

    <script>displayPlaylistMusic(<?php echo $playlist_id; ?>);</script>
</body>

</html>