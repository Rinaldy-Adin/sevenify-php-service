<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/albumService.php';

use common\Response;
use services\AlbumService;

class DeleteAlbumController
{
    function delete(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $user_id = (int)$_SESSION["user_id"];

        if (!is_numeric($pathEntries[count($pathEntries) - 1]))
            return (new Response(['message' => 'Album id invalid'], 400))->httpResponse();

        $album_id = (int)$pathEntries[count($pathEntries) - 1];

        $album = AlbumService::getInstance()->getByAlbumId($album_id);

        if (!$album || (int)($album->album_owner) != $user_id)
            return (new Response(['message' => 'Album does not exist'], 400))->httpResponse();

        AlbumService::getInstance()->deleteAlbum($album_id);
        return (new Response(['message' => 'Successfully deleted album']))->httpResponse();
    }
}
