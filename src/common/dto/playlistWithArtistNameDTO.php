<?php

namespace common\dto;
require_once ROOT_DIR . 'common/dto/dto.php';

use common\dto\DTO;

class PlaylistWithArtistNameDTO extends DTO
{
    public int $playlist_id;
    public string $playlist_name;
    public string $playlist_owner_name;

    public function __construct(
        int $playlist_id,
        string $playlist_name,
        string $playlist_owner_name,
    ) {
        $this->playlist_id = $playlist_id;
        $this->playlist_name = $playlist_name;
        $this->playlist_owner_name = $playlist_owner_name;
    }
}
