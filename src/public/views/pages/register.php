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
        <h1>Register</h1>
        <form onsubmit="register(event)">
            <div class="input-container">
                <label>Username</label>
                <input id="username" name="username" type="text" placeholder="Enter your username here">
            </div>
            <div class="input-container">
                <label>Password</label>
                <input id="password" name="password" type="password" placeholder="Enter your password">
            </div>
            <div class="input-container">
                <label>Confirm Password</label>
                <input id="confirm-password" name="confirm-password" type="password" placeholder="Confirm your password">
            </div>
            <input id="submit" type="submit" value="Register">
        </form>

    </div>
    <script src="public/javascript/adios.js"></script>
    <script src="public/javascript/register.js"></script>
</body>

</html>