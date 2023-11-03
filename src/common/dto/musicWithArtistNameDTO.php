<?php

namespace common\dto;
require_once ROOT_DIR . 'common/dto/dto.php';

use common\dto\DTO;
use DateTime;

class MusicWithArtistNameDTO extends DTO
{
    public int $music_id;
    public string $music_name;
    public string $music_owner_name;
    public int $music_owner_id;
    public string $music_genre;
    public DateTime $music_upload_date;

    public function __construct(
        int $music_id,
        string $music_name,
        int $music_owner_id,
        string $music_owner_name,
        string $music_genre,
        DateTime $music_upload_date
    ) {
        $this->music_id = $music_id;
        $this->music_name = $music_name;
        $this->music_owner_id = $music_owner_id;
        $this->music_owner_name = $music_owner_name;
        $this->music_genre = $music_genre;
        $this->music_upload_date = $music_upload_date;
    }
}
