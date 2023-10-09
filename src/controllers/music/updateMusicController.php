<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/musicService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\Response;
use exceptions\UnsupportedMediaTypeException;
use services\MusicService;

class UpdateMusicController
{
    function post(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

        if (!is_numeric($pathEntries[count($pathEntries) - 1]))
            return (new Response(['message' => 'Music id invalid'], 400))->httpResponse();

        $musicId = (int)$pathEntries[count($pathEntries) - 1];
        $title = $_POST["title"];
        $genre = $_POST["genre"];
        $user_id = $_POST["user-id"];
        $deleteCover = isset($_POST["delete-cover"]) ? true : false;
        $coverFile = $_FILES["cover-file"];


        if ($coverFile['error'] == UPLOAD_ERR_NO_FILE) {
            $coverFile = null;
        }

        if ($coverFile) {
            $mime = $coverFile['type'];
            $pattern = '/^image\/.*/';

            if (!preg_match($pattern, $mime))
                throw new UnsupportedMediaTypeException("Cover file is not an image");
        }

        
        $musicModel = (MusicService::getInstance())->updateMusic($musicId, $user_id, $title, $genre, $deleteCover, $coverFile);
        return (new Response($musicModel->toDTO()))->httpResponse();
    }
}
