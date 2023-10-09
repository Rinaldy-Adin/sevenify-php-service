<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/albumService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\Response;
use exceptions\UnsupportedMediaTypeException;
use services\AlbumService;

class CreateAlbumController
{
    function post(): string
    {
        $title = $_POST["title"];
        $user_id = $_SESSION["user_id"];
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

        $musicModel = AlbumService::getInstance()->createAlbum($title, $user_id, $coverFile);
        return (new Response($musicModel->toDTO()))->httpResponse();
    }
}
