<?php

namespace common\dto;
require_once ROOT_DIR . 'common/dto/dto.php';

use common\dto\DTO;

class MusicWithArtistNameDTO extends DTO
{
    public $music_id;
    public $music_name;
    public $music_owner_name;
    public $music_genre;

    public function __construct(
        int $music_id,
        string $music_name,
        string $music_owner_name,
        string $music_genre
    ) {
        $this->music_id = $music_id;
        $this->music_name = $music_name;
        $this->music_owner_name = $music_owner_name;
        $this->music_genre = $music_genre;
    }
}
