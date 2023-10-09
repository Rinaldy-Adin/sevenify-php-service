<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\Response;
use models\PlaylistModel;
use services\PlaylistService;

class CreatePlaylistController
{
    function post(): string
    {
        $title = $_POST["title"];
        $user_id = $_POST["user_id"];
        $coverFile = $_FILES["cover-file"];

        if ($coverFile['error'] == 4) {
            $coverFile = null;
        }

        $playlistModel = PlaylistService::getInstance()->createPlaylist($title, $user_id, $coverFile);
        return (new Response($playlistModel->toDTO()))->httpResponse();
    }
}
