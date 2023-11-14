<?php

namespace controllers\music;

require_once ROOT_DIR . 'services/musicService.php';
require_once ROOT_DIR . 'exceptions/BadRequestException.php';

use common\Response;
use exceptions\BadRequestException;
use services\MusicService;

class DeleteMusicController
{
    function delete(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

        if (!is_numeric($pathEntries[count($pathEntries) - 1]))
            return (new Response(['message' => 'Music id invalid'], 400))->httpResponse();

        $music_id = (int)$pathEntries[count($pathEntries) - 1];
        $user_id = (int)$_SESSION['user_id'];

        $music = MusicService::getInstance()->getMusicById($music_id);

        if ((int)$music->music_owner != $user_id)
            throw new BadRequestException("Music id does not exist");

        (MusicService::getInstance())->deleteMusic($music_id);
        return (new Response(['message' => 'Successfully deleted music']))->httpResponse();
    }
}
