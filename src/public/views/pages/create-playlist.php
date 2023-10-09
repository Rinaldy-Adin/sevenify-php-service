<?php
require_once ROOT_DIR . 'middlewares/authMiddleware.php';
use middlewares\AuthMiddleware;
AuthMiddleware::getInstance()->authUser();
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
    <form onsubmit="uploadPlaylist(event)">
        <div class="upload-bar hard-shadow">
            <h1 id="page-title">Upload Playlist</h1>
            <div></div>
        </div>

        <div class="form-container">
            <div class="image-container">
                <img id="cover-image" class="soft-shadow" src="/public/assets/placeholders/music-placeholder.jpg">
                <label for="cover-file">Image cover:</label>
                <input id="cover-file" type="file" name="cover-file" accept="image/*">
            </div>
            <div class="details-container">
                <div class="input-container">
                    <label>Title</label>
                    <input required name="title" type="text" placeholder="Enter your title here">
                </div>
                <input id="submit" type="submit" value="Save Playlist">
            </div>
        </div>
    </form>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/create-playlist.js"></script>
</body>

</html>