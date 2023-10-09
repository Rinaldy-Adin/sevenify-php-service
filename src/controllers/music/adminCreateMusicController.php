<?php

namespace controllers\music;

require_once ROOT_DIR . 'services/musicService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\Response;
use exceptions\UnsupportedMediaTypeException;
use services\MusicService;

class AdminCreateMusicController
{
    function post(): string
    {
        $title = $_POST["title"];
        $genre = $_POST["genre"];
        $user_id = $_POST["user-id"];
        $musicFile = $_FILES["music-file"];
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

        $musicModel = (MusicService::getInstance())->createMusic($user_id, $title, $genre, $musicFile, $coverFile);
        return (new Response($musicModel->toDTO()))->httpResponse();
    }
}
