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
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        $page = (int)$page;
        if (!is_int($page))
            throw new BadRequestException("Page requested not an integer");

        [$albumDTOs, $pageCount] = AlbumService::getInstance()->getAllAlbums($page);
        $searchResult = array_map(fn (AlbumModel $model) => $model->toDTO(), $albumDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
