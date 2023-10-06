<?php

namespace models;

require_once ROOT_DIR . 'models/model.php';

use DateTime;

class MusicModel extends Model
{
    public int $music_id;
    public string $music_name;
    public string $music_owner;
    public string $music_genre;
    public DateTime $music_upload_date;

    public function __construct(
        $music_id,
        $music_name,
        $music_owner,
        $music_genre,
        $music_upload_date
    ) {
        $this->music_id = $music_id;
        $this->music_name = $music_name;
        $this->music_owner = $music_owner;
        $this->music_genre = $music_genre;
        $this->music_upload_date = $music_upload_date;
    }
}
