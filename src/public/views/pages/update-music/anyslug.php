<?php
require_once ROOT_DIR . 'services/musicService.php';
require_once ROOT_DIR . 'services/userService.php';
require_once ROOT_DIR . 'middlewares/authMiddleware.php';

use middlewares\AuthMiddleware;
use services\UserService;
use services\MusicService;

AuthMiddleware::getInstance()->authUser();
$musicService = MusicService::getInstance();

$uri = $_SERVER['REQUEST_URI'];
$pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

if (!is_numeric($pathEntries[count($pathEntries) - 1])) {
    header('Location: /404');
} else {
    $music_id = (int)$pathEntries[count($pathEntries) - 1];
    $music = $musicService->getMusicById($music_id);

    if ($music == null) {
        header('Location: /404');
    }
}

$users = UserService::getInstance()->getAllUsers();

$options = [];
$musicOwnerName = '';
foreach ($users as $user) {
    if ($user->user_id == $music->music_owner) {
        $options[] = "<option selected value=\"$user->user_id\">$user->user_name</option>";
        $musicOwnerName = $user->user_name;
    } else {
        $options[] = "<option value=\"$user->user_id\">$user->user_name</option>";
    }
}

$coverPath = $musicService->getCoverPathByMusicId($music->music_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/create.css">
    <link rel="stylesheet" href="/public/styles/nav-bar.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/nav-bar.php'; ?>

    <form onsubmit="uploadMusic(event, <?= $music_id ?>)">
        <div class="upload-bar hard-shadow">
            <h1 id="page-title">Upload Music</h1>
            <div></div>
        </div>

        <div class="form-container">
            <div class="image-container">
                <img id="cover-image" class="soft-shadow" src='/public/assets/placeholders/music-placeholder.jpg'>
                <div class="delete-image-container">
                    <div>Delete current cover?</div>
                    <input type="checkbox" name="delete-cover">
                </div>
                <label for="cover-file">Change image cover:</label>
                <input id="cover-file" type="file" name="cover-file" accept="image/*">
            </div>
            <div class="details-container">
                <div class="input-container">
                    <label>Title (current: <?= $music->music_name ?>)</label>
                    <input required name="title" type="text" placeholder="Enter your title here" value="<?= $music->music_name ?>">
                </div>
                <div class="input-container">
                    <label>Genre (current: <?= $music->music_genre ?>)</label>
                    <input required name="genre" type="text" placeholder="Enter your genre here" value="<?= $music->music_genre ?>">
                </div>
                <input id="submit" type="submit" value="Save Music">
            </div>
        </div>
    </form>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/update-music.js"></script>
    <script>initUpdatePage(<?= $music_id ?>)</script>
</body>

</html>