<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/albumService.php';

use common\Response;
use services\AlbumService;

class GetAlbumCoverController
{
    function get(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $album_id = $pathEntries[count($pathEntries) - 1];

        $file = AlbumService::getInstance()->getCoverPathByAlbumId($album_id);
        if ($file) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: inline; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            return '';
        } else {
            return (new Response(['message' => 'Cover not found'], 400))->httpResponse();
        }
    }
}
