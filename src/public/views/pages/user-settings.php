<?php
require_once ROOT_DIR . 'middlewares/authMiddleware.php';

use middlewares\AuthMiddleware;

AuthMiddleware::getInstance()->authUser();
?>
<?php
require_once ROOT_DIR . 'services/userService.php';

use services\UserService;

$userService = UserService::getInstance();

$user_id = $_SESSION['user_id'];


$currentUser = $userService->getByUserId($user_id);

if ($currentUser == null) {
    header('Location: /404');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/styles/global.css">
    <link rel="stylesheet" href="public/styles/artist.css">
    <link rel="stylesheet" href="public/styles/user-settings.css">
    <link rel="stylesheet" href="/public/styles/nav-bar.css">
    <link rel="stylesheet" href="/public/styles/music-bar.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/nav-bar.php'; ?>

    <form onsubmit="updateUser(event)">
        <div class="upload-bar hard-shadow">
            <h1 id="page-title">User Settings</h1>
            <div></div>
        </div>

        <div class="form-container">
            <div class="details-container">
                <div class="input-container">
                    <label>Username (Current: <?= $currentUser->user_name ?>)</label>
                    <input name="username" type="text" placeholder="Enter your username here">
                </div>
                <div class="input-container">
                    <label>Password (Will be hashed)</label>
                    <input name="password" type="password" placeholder="Enter your password here">
                </div>
                <div class="input-container">
                    <label>Delete Account</label>
                    <button id="delete" onclick="deleteUser(<?= $currentUser->user_id ?>)">Delete Account</button>
                </div>
                <input id="submit" type="submit" value="Update User">
            </div>
        </div>
    </form>

    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/popup.js"></script>
    <script src="/public/javascript/user-settings.js"></script>
    <script src="/public/javascript/music-bar.js"></script>
</body>

</html>