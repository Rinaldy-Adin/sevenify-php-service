<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sevenify</title>
</head>
<body>
    <div class="auth-container">
        <h1>Login</h1>
        <form onsubmit="login(event)">
            <label>Username</label>
            <input id="username" name="username" type="text" placeholder="Enter your username here">
            <label>Password</label>
            <input id="password" name="password" type="password" placeholder="Enter your password">
            <input type="submit" value="Log in">
        </form>

        <script src="public/javascript/adios.js"></script>
        <script src="public/javascript/login.js"></script>
    </div>
</body>
</html>