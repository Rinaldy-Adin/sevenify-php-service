<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/admin-modify.css">
    <title>Sevenify</title>
</head>

<body>
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
                <div class="input-container">
                    <label>User</label>
                    <select required name="user-id">
                        <?php
                        use services\UserService;
                            require_once ROOT_DIR . 'services/userService.php';

                            $users = (new UserService())->getAllUsers();

                            foreach ($users as $user) {
                                echo " <option value=\"$user->user_id\">$user->user_name</option> " ;
                            }
                        ?>
                    </select>
                </div>
                <input id="submit" type="submit" value="Save Music">
            </div>
        </div>
    </form>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/admin/music/create.js"></script>
</body>

</html>