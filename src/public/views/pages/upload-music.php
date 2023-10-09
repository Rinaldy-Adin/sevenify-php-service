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
    <link rel="stylesheet" href="/public/styles/upload-music.css">
    <link rel="stylesheet" href="/public/styles/music-bar.css">
    <link rel="stylesheet" href="/public/styles/nav-bar.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/nav-bar.php'; ?>

    <form onsubmit="uploadMusic(event)">
        <div class="upload-bar hard-shadow">
            <h1 id="page-title">Upload Music</h1>
            <input required type="file" name="music-file" accept="audio/*">
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
                <div class="input-container">
                    <label>Genre</label>
                    <input required name="genre" type="text" placeholder="Enter your genre here">
                </div>
                <input id="submit" type="submit" value="Save Music">
            </div>
        </div>
    </form>

    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>
    
    <script src="public/javascript/adios.js"></script>
    <script src="public/javascript/upload-music.js"></script>
    <script src="public/javascript/music-bar.js"></script>
</body>

</html>