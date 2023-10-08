<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/music-bar.css">
    <link rel="stylesheet" href="/public/styles/admin.css">
    <link rel="stylesheet" href="/public/styles/nav-bar.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/nav-bar.php'; ?>

    <div class="container">
        <div class="title-container hard-shadow">
            <h1>Admin</h1>
        </div>
        <div class="content">
            <div class="admin-entities-container">
                <h2>Admin Entities</h2>
                <div class="admin-entities">
                    <?php require ROOT_DIR . "public/views/components/admin-sidebar.php";
                    renderAdminSidebar("playlist") ?>
                </div>
            </div>
            <div class="vertical-divider"></div>
            <div class="entity-data-container">
                <div class="entity-data-title">
                    <h2>Playlists</h2>
                    <a class="new-data-button" href="/admin/playlist/create">
                        New playlist
                    </a>
                </div>
                <div class="entity-data">
                    <table id="data-page-table" class="small-shadow">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Cover</th>
                                <th>id</th>
                                <th>Name</th>
                                <th>Owner ID</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="data-page-results">
                        </tbody>
                    </table>
                    <div id="pagination">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <script src="/public/javascript/adios.js"></script>
    <script src="/public/javascript/music-bar.js"></script>
    <script src="/public/javascript/admin/index.js"></script>
    <script src="/public/javascript/admin/playlist/index.js"></script>
</body>

</html>