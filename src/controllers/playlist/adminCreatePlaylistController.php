<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\Response;
use services\PlaylistService;

class AdminCreatePlaylistController
{
    function post(): string
    {
        $title = $_POST["title"];
        $user_id = $_POST["user-id"];
        $coverFile = $_FILES["cover-file"];
        $music_ids = isset($_POST["music"]) ? array_map(fn($id) => (int)$id, $_POST["music"]) : [];

        if ($coverFile['error'] == 4) {
            $coverFile = null;
        }

        $playlistModel = PlaylistService::getInstance()->createPlaylist($title, $user_id, $coverFile, $music_ids);
        return (new Response($playlistModel->toDTO()))->httpResponse();
    }
}
