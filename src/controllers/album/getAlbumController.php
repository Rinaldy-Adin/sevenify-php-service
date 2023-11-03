<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/albumService.php';
require_once ROOT_DIR . 'exceptions/BadRequestException.php';

use common\Response;
use exceptions\BadRequestException;
use models\AlbumModel;
use services\AlbumService;

class GetAlbumController
{
    function get(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $albumId = $pathEntries[count($pathEntries) - 1];

        if (!is_numeric($albumId))
            throw new BadRequestException("Album id requested not an integer");

        $album = AlbumService::getInstance()->getByAlbumId($albumId);
        if ($album) {
            return (new Response($album->toDTO()))->httpResponse();
        }
        throw new BadRequestException("Album not found");
    }
}
