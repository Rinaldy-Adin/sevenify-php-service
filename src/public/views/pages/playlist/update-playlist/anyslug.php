<?php
require_once ROOT_DIR . 'services/playlistService.php';
require_once ROOT_DIR . 'services/userService.php';
require_once ROOT_DIR . 'middlewares/authMiddleware.php';
require_once ROOT_DIR . 'middlewares/authMiddleware.php';

use middlewares\AuthMiddleware;
use services\PlaylistService;
use services\UserService;

AuthMiddleware::getInstance()->authUser();
AuthMiddleware::getInstance()->authUser();
$playlistService = PlaylistService::getInstance();

$uri = $_SERVER['REQUEST_URI'];
$pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

if (!is_numeric($pathEntries[count($pathEntries) - 1])) {
    header('Location: /404');
} else {
    $playlist_id = (int)$pathEntries[count($pathEntries) - 1];
    $playlist = $playlistService->getByPlaylistId($playlist_id);

    if ($playlist == null) {
        header('Location: /404');
    }
}

$users = UserService::getInstance()->getAllUsers();

$options = [];
$playlistOwnerName = '';
foreach ($users as $user) {
    if ($user->user_id == $playlist->playlist_owner) {
        $options[] = "<option selected value=\"$user->user_id\">$user->user_name</option>";
        $playlistOwnerName = $user->user_name;
    } else {
        $options[] = "<option value=\"$user->user_id\">$user->user_name</option>";
    }
}
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

    <form onsubmit="uploadPlaylist(event,  <?= $playlist_id ?>)">
        <div class="upload-bar hard-shadow">
            <h1 id="page-title">Update Album</h1>
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
                    <label>Title (current: <?= $playlist->playlist_name ?>)</label>
                    <input required name="title" type="text" placeholder="Enter your title here" value="<?= $playlist->playlist_name ?>">
                </div>
                <div class="input-container">
                    <label>User (current: <?= $playlistOwnerName ?>)</label>
                    <select required name="user-id">
                        <?php
                        echo implode(" ", $options);
                        ?>
                    </select>
                </div>
                <div class="input-container">
                    <label>Music</label>
                    <div class="dynamic-list-container">
                        <div class="dynamic-list-input-container">
                            <label>Add by id:</label>
                            <div class="dynamic-list-input">
                                <input type="text" placeholder="Enter music id to add" id="add-music-input">
                                <div onclick="addListItem()" id="add-music">Add Music</div>
                            </div>
                        </div>
                        <ul id="dynamic-list">
                        </ul>
                    </div>
                </div>
                <input id="submit" type="submit" value="Save Playlist">
            </div>
        </div>
    </form>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/update-playlist.js"></script>
    <script>
        initUpdatePage(<?= $playlist_id ?>)
    </script>
</body>

</html>