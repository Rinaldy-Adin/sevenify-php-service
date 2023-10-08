<?php

namespace rest;

require_once ROOT_DIR . 'controllers/auth/loginController.php';
require_once ROOT_DIR . 'controllers/auth/registerController.php';
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
require_once ROOT_DIR . 'controllers/user/getUserController.php';
require_once ROOT_DIR . 'controllers/music/findUserMusicController.php';
require_once ROOT_DIR . 'controllers/music/findUserPlaylistController.php';
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
use controllers\playlist\AdminCreatePlaylistController;
use controllers\playlist\AdminDeletePlaylistController;
use controllers\playlist\AdminGetPlaylistController;
use controllers\playlist\AdminGetPlaylistMusicController;
use controllers\playlist\AdminUpdatePlaylistController;
use controllers\playlist\GetPlaylistCoverController;
use controllers\playlist\SearchPlaylistMusicController;
use controllers\playlist\CreatePlaylistController;
use controllers\playlist\UpdatePlaylistController;

// TODO: move this to /router

class APIRoutes
{
    public static array $apiroutes = [
        ['/api/login', 'post', LoginController::class],
        ['/api/register', 'post', RegisterController::class],
        ['/api/music', 'post', CreateMusicController::class],
        ['/api/music/*', 'get', GetMusicController::class],
        ['/api/audio/*', 'get', GetAudioController::class],
        ['/api/music-cover/*', 'get', GetMusicCoverController::class],
        ['/api/album-cover/*', 'get', GetAlbumCoverController::class],
        ['/api/playlist-cover/*', 'get', GetPlaylistCoverController::class],
        ['/api/user/*', 'get', GetUserController::class],
        ['/api/search', 'get', SearchMusicController::class],
        ['/api/genres', 'get', GetGenresController::class],
        ['/api/searchUser', 'get', FindUserMusicController::class],
        ['/api/searchAlbumUser', 'get', FindUserAlbumController::class],
        ['/api/searchAlbumMusic', 'get', SearchAlbumMusicController::class],
        ['/api/searchPlaylistMusic', 'get', SearchPlaylistMusicController::class],
        ['/api/createAlbum', 'post', CreateAlbumController::class],
        ['/api/createPlaylist', 'post', CreatePlaylistController::class],
        ['/api/updateMusic/*', 'post', UpdateMusicController::class],
        ['/api/updateAlbum/*', 'post', UpdateAlbumController::class],
        ['/api/updatePlaylist/*', 'post', UpdatePlaylistController::class],
        ['/api/searchPlaylistUser', 'get', FindUserPlaylistController::class],
        ['/api/admin/music', 'get', AdminGetMusicController::class],
        ['/api/admin/music', 'post', AdminCreateMusicController::class],
        ['/api/admin/music/*', 'delete', AdminDeleteMusicController::class],
        ['/api/admin/music/*', 'post', AdminUpdateMusicController::class],
        ['/api/admin/album', 'get', AdminGetAlbumController::class],
        ['/api/admin/album', 'post', AdminCreateAlbumController::class],
        ['/api/admin/album/*', 'delete', AdminDeleteAlbumController::class],
        ['/api/admin/album/*', 'post', AdminUpdateAlbumController::class],
        ['/api/admin/playlist-music/*', 'get', AdminGetPlaylistMusicController::class],
        ['/api/admin/playlist', 'get', AdminGetPlaylistController::class],
        ['/api/admin/playlist', 'post', AdminCreatePlaylistController::class],
        ['/api/admin/playlist/*', 'delete', AdminDeletePlaylistController::class],
        ['/api/admin/playlist/*', 'post', AdminUpdatePlaylistController::class],
        ['/api/admin/playlist-music/*', 'get', AdminGetPlaylistMusicController::class],
    ];
}
