<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/musicService.php';

use common\Response;
use services\MusicService;

class GetGenresController
{
    function get(): string
    {
        $genres = (MusicService::getInstance())->getAllGenres();
        return (new Response(["genres" => $genres]))->httpResponse();
    }
}
