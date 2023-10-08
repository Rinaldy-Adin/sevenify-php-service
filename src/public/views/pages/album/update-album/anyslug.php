<?php
require_once ROOT_DIR . 'services/albumService.php';
require_once ROOT_DIR . 'services/userService.php';

use services\AlbumService;
use services\UserService;

$albumService = new AlbumService();

$uri = $_SERVER['REQUEST_URI'];
$pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

if (!is_numeric($pathEntries[count($pathEntries) - 1])) {
    header('Location: /404');
} else {
    $album_id = (int)$pathEntries[count($pathEntries) - 1];
    $album = $albumService->getByAlbumId($album_id);

    if ($album == null) {
        header('Location: /404');
    }
}

[$users] = (new UserService())->getAllUsers();

$options = [];
$albumOwnerName = '';
foreach ($users as $user) {
    if ($user->user_id == $album->album_owner) {
        $options[] = "<option selected value=\"$user->user_id\">$user->user_name</option>";
        $albumOwnerName = $user->user_name;
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
    <title>Sevenify</title>
</head>

<body>
    <form onsubmit="uploadAlbum(event,  <?= $album_id ?>)">
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
                    <label>Title (current: <?= $album->album_name ?>)</label>
                    <input required name="title" type="text" placeholder="Enter your title here" value="<?= $album->album_name ?>">
                </div>
                <div class="input-container">
                    <label>User (current: <?= $albumOwnerName ?>)</label>
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
                <input id="submit" type="submit" value="Save Album">
            </div>
        </div>
    </form>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/update-album.js"></script>
    <script>
        initUpdatePage(<?= $album_id ?>)
    </script>
</body>

</html>