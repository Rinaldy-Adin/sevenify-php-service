<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/albumService.php';

use common\Response;
use services\AlbumService;

class AdminDeleteAlbumController
{
    function delete(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

        if (!is_numeric($pathEntries[count($pathEntries) - 1]))
            return (new Response(['message' => 'Album id invalid'], 400))->httpResponse();

        $album_id = (int)$pathEntries[count($pathEntries) - 1];

        AlbumService::getInstance()->deleteAlbum($album_id);
        return (new Response(['message' => 'Successfully deleted album']))->httpResponse();
    }
}
