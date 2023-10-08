<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/admin-modify.css">
    <title>Sevenify</title>
</head>

<body>
    <form onsubmit="uploadUser(event)">
        <div class="upload-bar hard-shadow">
            <h1 id="page-title">New User</h1>
        </div>

        <div class="form-container">
            <div class="details-container">
                <div class="input-container">
                    <label>Username</label>
                    <input required name="username" type="text" placeholder="Enter your username here">
                </div>
                <div class="input-container">
                    <label>Password (Will be hashed)</label>
                    <input required name="password" type="password" placeholder="Enter your password here">
                </div>
                <div class="input-container">
                    <label>User is admin <input name="is-admin" type="checkbox"></label>
                </div>
                <input id="submit" type="submit" value="Create user">
            </div>
        </div>
    </form>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/admin/user/create.js"></script>
</body>

</html>