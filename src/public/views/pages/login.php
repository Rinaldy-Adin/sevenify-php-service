<?php
require_once ROOT_DIR . 'middlewares/authMiddleware.php';

use middlewares\AuthMiddleware;

AuthMiddleware::getInstance()->authUnauthenticated()
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/auth.css">
    <title>Sevenify</title>
</head>

<body>
    <div class="auth-container">
        <h1>Login</h1>
        <form onsubmit="login(event)">
            <div class="input-container">
                <label>Username</label>
                <input id="username" name="username" type="text" placeholder="Enter your username here">
            </div>
            <div class="input-container">
                <label>Password</label>
                <input id="password" name="password" type="password" placeholder="Enter your password">
            </div>
            <input id="submit" type="submit" value="Log in">
        </form>
        <p class="go-to-other">Don't have an account? <a href="/register">Register</a></p>
    </div>

    <script src="public/javascript/adios.js"></script>
    <script src="public/javascript/login.js"></script>
</body>

</html>