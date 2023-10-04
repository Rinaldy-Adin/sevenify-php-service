<?php

namespace controllers\music;
use common\Response;
use service\MusicService;

class GetMusicController {
    function get() : string {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $music_id = $pathEntries[count($pathEntries) - 1];

        $musicModel = (new MusicService())->getByMusicId($music_id);
        return (new Response($musicModel->toDTO()))->httpResponse();
    }
}