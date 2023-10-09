<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/playlistService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\Response;
use exceptions\UnsupportedMediaTypeException;
use services\PlaylistService;

class AdminCreatePlaylistController
{
    function post(): string
    {
        $title = $_POST["title"];
        $user_id = $_POST["user-id"];
        $coverFile = $_FILES["cover-file"];
        $music_ids = isset($_POST["music"]) ? array_map(fn($id) => (int)$id, $_POST["music"]) : [];

        if ($coverFile['error'] == UPLOAD_ERR_NO_FILE) {
            $coverFile = null;
        }

        if ($coverFile) {
            $mime = $coverFile['type'];
            $pattern = '/^image\/.*/';

            if (!preg_match($pattern, $mime))
                throw new UnsupportedMediaTypeException("Cover file is not an image");
        }

        $playlistModel = PlaylistService::getInstance()->createPlaylist($title, $user_id, $coverFile, $music_ids);
        return (new Response($playlistModel->toDTO()))->httpResponse();
    }
}
