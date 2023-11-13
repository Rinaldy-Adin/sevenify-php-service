<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/musicService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\Response;
use exceptions\UnsupportedMediaTypeException;
use services\MusicService;

class CreateMusicController
{
    function post(): string
    {
        $title = $_POST["title"];
        $genre = $_POST["genre"];
        $musicFile = isset($_FILES["music-file"]) ? $_FILES["music-file"] : null;
        $coverFile = isset($_FILES["cover-file"]) ? $_FILES["cover-file"] : null;

        $user_id = $_SESSION["user_id"];

        if ($coverFile['error'] == 4) {
            $coverFile = null;
        }

        if ($musicFile) {
            $mime = $musicFile['type'];
            $pattern = '/^audio\/.*/';

            if (!preg_match($pattern, $mime))
                throw new UnsupportedMediaTypeException("Cover file is not an audio file");
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
