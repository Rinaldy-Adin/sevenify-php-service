<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\Response;
use services\PlaylistService;

class AdminUpdatePlaylistController
{
    function post(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $playlist_id = $pathEntries[count($pathEntries) - 1];

        $title = $_POST["title"];
        $user_id = $_POST["user-id"];
        $coverFile = $_FILES["cover-file"];
        $deleteCover = isset($_POST["delete-cover"]) ? true : false;
        $music_ids = isset($_POST["music"]) ? array_map(fn($id) => (int)$id, $_POST["music"]) : [];

        if ($coverFile['error'] == 4) {
            $coverFile = null;
        }

        $musicModel = (new PlaylistService())->updatePlaylist($playlist_id, $title, $user_id, $deleteCover, $coverFile, $music_ids);
        if ($musicModel !== null) {
            return (new Response($musicModel->toDTO()))->httpResponse();
        } else {
            http_response_code(500);
            return (new Response(['message' => 'Error creating music'], 500))->httpResponse();
        }
    }
}
