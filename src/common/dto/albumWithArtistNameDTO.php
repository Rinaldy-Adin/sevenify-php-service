<?php

namespace common\dto;
require_once ROOT_DIR . 'common/dto/dto.php';

use common\dto\DTO;

class AlbumWithArtistNameDTO extends DTO
{
    public int $album_id;
    public string $album_name;
    public string $album_owner_name;

    public function __construct(
        int $album_id,
        string $album_name,
        string $album_owner_name,
    ) {
        $this->album_id = $album_id;
        $this->album_name = $album_name;
        $this->album_owner_name = $album_owner_name;
    }
}
