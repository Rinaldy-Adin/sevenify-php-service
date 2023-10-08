<?php
require_once ROOT_DIR . 'services/userService.php';

use services\UserService;
$userService = UserService::getInstance();

$user = $userService->getByUserId($_SESSION['user_id']);
?>
<div class="sidebar">
    <div class="logo">
        <img src="/public/assets/media/sevenify.png" alt="Sevenify Logo">
    </div>
    <ul class="nav-links">
        <li><a href="/"><img src="/public/assets/icons/home.png"alt="Home Page">Home Page</a></li>
        <li><a href="/search"><img src="/public/assets/icons/search.png" alt="Search">Search</a></li>
        <li><a href="#"><img src="/public/assets/icons/album.png" alt="Album & Playlist">Album & Playlist</a></li>
        <li><a href="#"><img src="/public/assets/icons/music.png" alt="Music">Music</a></li>
        <li><a href="/upload-music"><img src="/public/assets/icons/add.png" alt="Add Music">Add Music</a></li>
        <li><a href="/user-settings"><img src="/public/assets/icons/user.png" alt="User Account Settings">User Account Setings</a></li>
        <?php
            if ($user->role == 'admin') {
                echo '<li><a href="/admin/music/"><img src="/public/assets/icons/admin.svg" alt="User Admin Page">Admin</a></li>';
            }
        ?>
    </ul>
</div>
