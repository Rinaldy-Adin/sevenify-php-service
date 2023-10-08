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
    $playlist = $playlistService->getPlaylistByIdName($playlist_id);

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
            <script>
                async function fetchPlaylistCover() {
                    let cover = '';
                    try {
                        const playlist_id = <?= $playlist_id; ?>;
                        const coverResp = await adios.get(`/api/playlist-cover/${playlist_id}`, {}, true);
                        cover = URL.createObjectURL(coverResp);
                    } catch (error) {
                        cover = "/public/assets/placeholders/playlist-placeholder.png";
                    }
                    return cover;
                }

                document.addEventListener("DOMContentLoaded", async function () {
                    const playlistMusicList = document.getElementById('playlist-music-list');
                    const playlistId = <?= $playlist_id; ?>;
                    const cover = await fetchPlaylistCover();

                    // Gunakan variabel 'cover' di sini
                    document.querySelector('.playlist-cover img').src = cover;

                    displayPlaylistMusic(playlistId);
                });
            </script>
            <img src="<?php echo $cover; ?>" alt="Playlist Cover">
        </div>
        <div class="playlist-name">
            <?= $playlist[0]->playlist_name ?>
        </div>    
        <div class="playlist-owner">
            <?= $playlist[0]->playlist_owner_name ?>
        </div>
    </section>

    <section id="playlist-music-list">
        <h2>Playlist's Music</h2>
        <div id="playlist-music-item"></div>
        <div id="pagination-playlist-music"></div>
    </section>

    <script src="../../../public/javascript/adios.js"></script>
    <script src="../../../public/javascript/music-bar.js"></script>
    <script src="../../../public/javascript/playlist-music-list.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const playlistMusicList = document.getElementById('playlist-music-list');

        const playlistId = <?php echo $playlist_id; ?>;
        displayPlaylistMusic(playlistId);
    });
    </script>

</body>

</html>