<?php
require_once ROOT_DIR . 'middlewares/authMiddleware.php';
use middlewares\AuthMiddleware;
AuthMiddleware::getInstance()->authUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/styles/global.css">
    <link rel="stylesheet" href="public/styles/account.css"> 
</head>
<body>
    <header>
        <h1>Profil Setting</h1>
    </header>
    <button id="back-button">Back</button>
    <main>
        <section id="profile-section">
            <h2>Profile</h2>
            <div class="profile-info">
                <p id="profile-name">Nama Pemilik</p>
                <button id="edit-profile-button">Edit Name</button>
            </div>
        </section>
        <section id="gmail-section">
            <h2>Gmail Account</h2>
            <div class="gmail-info">
                <p id="gmail-address">akun@gmail.com</p>
                <button id="edit-gmail-button">Edit Gmail</button>
            </div>
            <button id="save-button">Simpan</button>
        </section>
        <button id="logout-button">Logout</button>
    </main>
    <script src="public/javascript/account.js"></script> 
</body>
</html>
