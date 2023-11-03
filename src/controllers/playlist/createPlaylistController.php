<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/playlistService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\Response;
use exceptions\UnsupportedMediaTypeException;
use services\PlaylistService;

class CreatePlaylistController
{
    function post(): string
    {
        $title = $_POST["title"];
        $user_id = $_SESSION["user_id"];
        $coverFile = $_FILES["cover-file"];

        if ($coverFile['error'] == 4) {
            $coverFile = null;
        }

        if ($coverFile) {
            $mime = $coverFile['type'];
            $pattern = '/^image\/.*/';

            if (!preg_match($pattern, $mime))
                throw new UnsupportedMediaTypeException("Cover file is not an image");
        }

        $playlistModel = PlaylistService::getInstance()->createPlaylist($title, $user_id, $coverFile);
        return (new Response($playlistModel->toDTO()))->httpResponse();
    }
}
