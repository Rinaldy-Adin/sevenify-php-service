<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/albumService.php';

use common\Response;
use models\AlbumModel;
use services\AlbumService;

class AdminGetAlbumController
{
    function get(): string
    {
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        [$albumDTOs, $pageCount] = (new AlbumService())->getAllAlbums($page);
        $searchResult = array_map(fn(AlbumModel $model) => $model->toDTO(), $albumDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
