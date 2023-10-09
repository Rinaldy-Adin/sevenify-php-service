<?php
require_once ROOT_DIR . 'middlewares/authMiddleware.php';
use middlewares\AuthMiddleware;
AuthMiddleware::getInstance()->authAdmin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/admin-modify.css">
    <link rel="stylesheet" href="/public/styles/nav-bar.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/nav-bar.php'; ?>

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
                <div class="input-container">
                    <label>User</label>
                    <select required name="user-id">
                        <?php

                        use services\UserService;

                        require_once ROOT_DIR . 'services/userService.php';

                        $users = UserService::getInstance()->getAllUsers();

                        foreach ($users as $user) {
                            echo " <option value=\"$user->user_id\">$user->user_name</option> ";
                        }
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
    <script src="/public/javascript/admin/playlist/create.js"></script>
</body>

</html>