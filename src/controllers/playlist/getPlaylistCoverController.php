<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\Response;
use services\PlaylistService;

class GetPlaylistCoverController
{
    function get(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $playlist_id = $pathEntries[count($pathEntries) - 1];

        $file = PlaylistService::getInstance()->getCoverPathByPlaylistId($playlist_id);
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
