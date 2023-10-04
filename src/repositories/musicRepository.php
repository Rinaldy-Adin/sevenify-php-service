<?php

namespace repositories;
require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/musicModel.php';

use models\MusicModel;
use PDO;

class MusicRepository extends Repository {
    public function getMusicByUserId($userId)
    {
        $query = "SELECT * FROM music WHERE music_owner = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        $musicRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert music records to Music model objects
        $musicObjects = [];
        foreach ($musicRecords as $musicRecord) {
            $music = new MusicModel(
                $musicRecord['music_id'],
                $musicRecord['music_name'],
                $musicRecord['music_owner'],
                $musicRecord['music_duration'],
                $musicRecord['music_audio_path'],
                $musicRecord['music_genre'],
                $musicRecord['album_id']
            );
            $musicObjects[] = $music;
        }

        return $musicObjects;
    }
}