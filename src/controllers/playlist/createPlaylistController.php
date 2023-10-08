<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\Response;
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

        $musicModel = (new PlaylistService())->createPlaylist($title, $user_id, $coverFile);
        if ($musicModel !== null) {
            return (new Response($musicModel->toDTO()))->httpResponse();
        } else {
            http_response_code(500);
            return (new Response(['message' => 'Error creating music'], 500))->httpResponse();
        }
    }
}
