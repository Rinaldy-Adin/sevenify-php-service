<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/playlistService.php';
require_once ROOT_DIR . 'exceptions/BadRequestException.php';

use common\Response;
use exceptions\BadRequestException;
use models\PlaylistModel;
use services\PlaylistService;

class GetPlaylistController
{
    function get(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $playlistId = $pathEntries[count($pathEntries) - 1];

        if (!is_numeric($playlistId)) 
            throw new BadRequestException("Playlist id requested not an integer");

        $playlist = PlaylistService::getInstance()->getByPlaylistId($playlistId);
        if ($playlist)
            return (new Response($playlist->toDTO()))->httpResponse();
        else
        return (new Response(['message' => 'Playlist not found']))->httpResponse();
    }
}
