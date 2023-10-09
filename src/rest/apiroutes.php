<?php

namespace rest;

require_once ROOT_DIR . 'controllers/auth/loginController.php';
require_once ROOT_DIR . 'controllers/auth/registerController.php';
require_once ROOT_DIR . 'controllers/auth/logoutController.php';
require_once ROOT_DIR . 'controllers/music/createMusicController.php';
require_once ROOT_DIR . 'controllers/music/getMusicController.php';
require_once ROOT_DIR . 'controllers/music/getAudioController.php';
require_once ROOT_DIR . 'controllers/music/getGenresController.php';
require_once ROOT_DIR . 'controllers/music/getMusicCoverController.php';
require_once ROOT_DIR . 'controllers/music/searchMusicController.php';
require_once ROOT_DIR . 'controllers/music/updateMusicController.php';
require_once ROOT_DIR . 'controllers/music/adminGetMusicController.php';
require_once ROOT_DIR . 'controllers/music/adminCreateMusicController.php';
require_once ROOT_DIR . 'controllers/music/adminDeleteMusicController.php';
require_once ROOT_DIR . 'controllers/music/adminUpdateMusicController.php';
require_once ROOT_DIR . 'controllers/music/findUserMusicController.php';
require_once ROOT_DIR . 'controllers/music/findUserPlaylistController.php';
require_once ROOT_DIR . 'controllers/user/getUserController.php';
require_once ROOT_DIR . 'controllers/user/adminGetUserController.php';
require_once ROOT_DIR . 'controllers/user/adminCreateUserController.php';
require_once ROOT_DIR . 'controllers/user/adminDeleteUserController.php';
require_once ROOT_DIR . 'controllers/user/adminUpdateUserController.php';
require_once ROOT_DIR . 'controllers/user/updateUserController.php';
require_once ROOT_DIR . 'controllers/user/deleteUserController.php';
require_once ROOT_DIR . 'controllers/album/getAlbumCoverController.php';
require_once ROOT_DIR . 'controllers/album/createAlbumController.php';
require_once ROOT_DIR . 'controllers/album/updateAlbumController.php';
require_once ROOT_DIR . 'controllers/album/adminCreateAlbumController.php';
require_once ROOT_DIR . 'controllers/album/adminDeleteAlbumController.php';
require_once ROOT_DIR . 'controllers/album/adminGetAlbumController.php';
require_once ROOT_DIR . 'controllers/album/adminGetAlbumMusicController.php';
require_once ROOT_DIR . 'controllers/album/adminUpdateAlbumController.php';
require_once ROOT_DIR . 'controllers/album/findUserAlbumController.php';
require_once ROOT_DIR . 'controllers/album/searchAlbumMusicController.php';
require_once ROOT_DIR . 'controllers/playlist/createPlaylistController.php';
require_once ROOT_DIR . 'controllers/playlist/updatePlaylistController.php';
require_once ROOT_DIR . 'controllers/playlist/adminCreatePlaylistController.php';
require_once ROOT_DIR . 'controllers/playlist/adminDeletePlaylistController.php';
require_once ROOT_DIR . 'controllers/playlist/adminGetPlaylistController.php';
require_once ROOT_DIR . 'controllers/playlist/adminGetPlaylistMusicController.php';
require_once ROOT_DIR . 'controllers/playlist/adminUpdatePlaylistController.php';
require_once ROOT_DIR . 'controllers/playlist/getPlaylistCoverController.php';
require_once ROOT_DIR . 'controllers/playlist/searchPlaylistMusicController.php';

use controllers\album\AddMusicToAlbum;
use controllers\album\AdminCreateAlbumController;
use controllers\album\AdminDeleteAlbumController;
use controllers\album\AdminGetAlbumController;
use controllers\album\AdminGetAlbumMusicController;
use controllers\album\AdminUpdateAlbumController;
use controllers\album\GetAlbumCoverController;
use controllers\album\FindUserAlbumController;
use controllers\album\SearchAlbumMusicController;
use controllers\album\CreateAlbumController;
use controllers\album\UpdateAlbumController;
use controllers\auth\LoginController;
use controllers\auth\LogoutController;
use controllers\auth\RegisterController;
use controllers\music\AdminCreateMusicController;
use controllers\music\AdminDeleteMusicController;
use controllers\music\AdminGetMusicController;
use controllers\music\AdminUpdateMusicController;
use controllers\music\CreateMusicController;
use controllers\music\UpdateMusicController;
use controllers\music\GetAudioController;
use controllers\music\GetGenresController;
use controllers\music\GetMusicController;
use controllers\music\GetMusicCoverController;
use controllers\music\GetUserController;
use controllers\music\SearchMusicController;
use controllers\music\FindUserMusicController;
use controllers\music\FindUserPlaylistController;
use controllers\playlist\AddMusicToPlaylist;
use controllers\playlist\AdminCreatePlaylistController;
use controllers\playlist\AdminDeletePlaylistController;
use controllers\playlist\AdminGetPlaylistController;
use controllers\playlist\AdminGetPlaylistMusicController;
use controllers\playlist\AdminUpdatePlaylistController;
use controllers\playlist\GetPlaylistCoverController;
use controllers\playlist\SearchPlaylistMusicController;
use controllers\playlist\CreatePlaylistController;
use controllers\playlist\UpdatePlaylistController;
use controllers\user\AdminGetUserController;
use controllers\user\AdminCreateUserController;
use controllers\user\AdminDeleteUserController;
use controllers\user\AdminUpdateUserController;
use controllers\user\DeleteUserController;
use controllers\user\UpdateUserController;

// TODO: move this to /router

class APIRoutes
{
    public static array $apiroutes = [
        ['/api/login', 'post', LoginController::class, 'unauthenticated'],
        ['/api/register', 'post', RegisterController::class, 'unauthenticated'],
        ['/api/logout', 'get', LogoutController::class],
        ['/api/music', 'post', CreateMusicController::class],
        ['/api/music/*', 'get', GetMusicController::class],
        ['/api/audio/*', 'get', GetAudioController::class],
        ['/api/music-cover/*', 'get', GetMusicCoverController::class],
        ['/api/album-cover/*', 'get', GetAlbumCoverController::class],
        ['/api/playlist-cover/*', 'get', GetPlaylistCoverController::class],
        ['/api/user', 'post', UpdateUserController::class],
        ['/api/user', 'delete', DeleteUserController::class],
        ['/api/user/*', 'get', GetUserController::class],
        ['/api/search', 'get', SearchMusicController::class],
        ['/api/genres', 'get', GetGenresController::class],
        ['/api/search-user', 'get', FindUserMusicController::class],
        ['/api/search-album-user', 'get', FindUserAlbumController::class],
        ['/api/search-album-music', 'get', SearchAlbumMusicController::class],
        ['/api/search-playlist-music', 'get', SearchPlaylistMusicController::class],
        ['/api/create-album', 'post', CreateAlbumController::class],
        ['/api/create-playlist', 'post', CreatePlaylistController::class],
        ['/api/update-music/*', 'post', UpdateMusicController::class],
        ['/api/update-album/*', 'post', UpdateAlbumController::class],
        ['/api/update-playlist/*', 'post', UpdatePlaylistController::class],
        ['/api/playlist/add-music/*', 'post', AddMusicToPlaylist::class],
        ['/api/album/add-music/*', 'post', AddMusicToAlbum::class],
        ['/api/search-playlist-user', 'get', FindUserPlaylistController::class],
        ['/api/admin/music', 'get', AdminGetMusicController::class, 'admin'],
        ['/api/admin/music', 'post', AdminCreateMusicController::class, 'admin'],
        ['/api/admin/music/*', 'delete', AdminDeleteMusicController::class, 'admin'],
        ['/api/admin/music/*', 'post', AdminUpdateMusicController::class, 'admin'],
        ['/api/admin/album', 'get', AdminGetAlbumController::class, 'admin'],
        ['/api/admin/album', 'post', AdminCreateAlbumController::class, 'admin'],
        ['/api/admin/album/*', 'delete', AdminDeleteAlbumController::class, 'admin'],
        ['/api/admin/album/*', 'post', AdminUpdateAlbumController::class, 'admin'],
        ['/api/admin/album-music/*', 'get', AdminGetAlbumMusicController::class, 'admin'],
        ['/api/admin/playlist', 'get', AdminGetPlaylistController::class, 'admin'],
        ['/api/admin/playlist', 'post', AdminCreatePlaylistController::class, 'admin'],
        ['/api/admin/playlist/*', 'delete', AdminDeletePlaylistController::class, 'admin'],
        ['/api/admin/playlist/*', 'post', AdminUpdatePlaylistController::class, 'admin'],
        ['/api/admin/playlist-music/*', 'get', AdminGetPlaylistMusicController::class, 'admin'],
        ['/api/admin/user', 'get', AdminGetUserController::class, 'admin'],
        ['/api/admin/user', 'post', AdminCreateUserController::class, 'admin'],
        ['/api/admin/user/*', 'delete', AdminDeleteUserController::class, 'admin'],
        ['/api/admin/user/*', 'post', AdminUpdateUserController::class, 'admin']
    ];
}
