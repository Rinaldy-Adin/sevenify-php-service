<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/musicService.php';

use common\Response;
use services\MusicService;

class GetAudioController
{
    function get(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $music_id = $pathEntries[count($pathEntries) - 1];

        $file = (new MusicService())->getAudioPathByMusicId($music_id);
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
            return (new Response(['message' => 'Audio not found'], 400))->httpResponse();
        }
    }
}
