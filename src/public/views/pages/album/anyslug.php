<?php
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'repositories/musicRepository.php';
require_once ROOT_DIR . 'repositories/albumRepository.php';
require_once ROOT_DIR . 'services/albumService.php';
require_once ROOT_DIR . 'services/userService.php';

use models\MusicModel;
use repositories\MusicRepository;
use repositories\AlbumRepository;
use services\UserService;
use services\AlbumService;

$albumService = new AlbumService();

$uri = $_SERVER['REQUEST_URI'];
$pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

if (!is_numeric($pathEntries[count($pathEntries) - 1])) {
    header('Location: /404');
} else {
    $album_id = (int)$pathEntries[count($pathEntries) - 1];
    $album = $albumService->getAlbumByIdName($album_id);

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
    <link rel="stylesheet" href="/public/styles/album-music-list.css">
    <title>Sevenify : Album</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <section id="album-music">
        <div class="album-cover">
            <script>
                async function fetchAlbumCover() {
                    let cover = '';
                    try {
                        const album_id = <?= $album_id; ?>;
                        const coverResp = await adios.get(`/api/album-cover/${album_id}`, {}, true);
                        cover = URL.createObjectURL(coverResp);
                    } catch (error) {
                        cover = "/public/assets/placeholders/album-placeholder.png";
                    }
                    return cover;
                }

                document.addEventListener("DOMContentLoaded", async function () {
                    const albumMusicList = document.getElementById('album-music-list');
                    const albumId = <?= $album_id; ?>;
                    const cover = await fetchAlbumCover();

                    // Gunakan variabel 'cover' di sini
                    document.querySelector('.album-cover img').src = cover;

                    displayAlbumMusic(albumId);
                });
            </script>
            <img src="<?php echo $cover; ?>" alt="Album Cover">
        </div>
        <div class="album-name">
            <?= $album[0]->album_name ?>
        </div>    
        <div class="album-owner">
            <?= $album[0]->album_owner_name ?>
        </div>
    </section>

    <section id="album-music-list">
        <h2>Album's Music</h2>
        <div id="album-music-item"></div>
        <div id="pagination-album-music"></div>
    </section>

    <script src="../../../public/javascript/adios.js"></script>
    <script src="../../../public/javascript/music-bar.js"></script>
    <script src="../../../public/javascript/album-music-list.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const albumMusicList = document.getElementById('album-music-list');

        const albumId = <?php echo $album_id; ?>;
        displayAlbumMusic(albumId);
    });
    </script>

</body>

</html>