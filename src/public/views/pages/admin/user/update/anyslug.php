<?php
require_once ROOT_DIR . 'middlewares/authMiddleware.php';
use middlewares\AuthMiddleware;
AuthMiddleware::getInstance()->authAdmin();
?>
<?php
require_once ROOT_DIR . 'services/userService.php';

use services\UserService;

$userService = UserService::getInstance();

$uri = $_SERVER['REQUEST_URI'];
$pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

$currentUser = null;

if (!is_numeric($pathEntries[count($pathEntries) - 1])) {
    header('Location: /404');
} else {
    $user_id = (int)$pathEntries[count($pathEntries) - 1];
    $currentUser = $userService->getByUserId($user_id);

    if ($currentUser == null) {
        header('Location: /404');
    }
}
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

    <form onsubmit="uploadUser(event, <?= $currentUser->user_id ?>)">
        <div class="upload-bar hard-shadow">
            <h1 id="page-title">Update User</h1>
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
                    <label>User is admin <input name="is-admin" type="checkbox" <?= $currentUser->role == "admin" ? "checked" : ''?>></label>
                    (Current role: <?= $currentUser->role ?>)
                </div>
                <input id="submit" type="submit" value="Update User">
            </div>
        </div>
    </form>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/admin/user/update.js"></script>
</body>

</html>