<?php

namespace repositories;

use models\MusicModel;
use PDO;

class MusicRepository extends \Repository {
    public function getAllMusics() {
        $query = "SELECT * FROM music";
        $stmt = $this->db->query($query);

        $musics = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $music = new MusicModel($row['music_id'], $row['music_name'], $row['music_owner'], $row['mosuc_duration'], $row['music_audio_path'], $row['music_genre'], $row['album_id']);
            $musics[] = $music;
        }

        return $musics;
    }

    public function getMusicById($musicId) {
        $query = "SELECT * FROM music WHERE music_id = :music_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":music_id", $musicId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new MusicModel($row['music_id'], $row['music_name'], $row['music_owner'], $row['mosuc_duration'], $row['music_audio_path'], $row['music_genre'], $row['album_id']);
        } else {
            return null; // Music not found
        }
    }

    public function countAllMusic(){
        $query = "SELECT COUNT(*) FROM music";
        $stmt = $this->db->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['COUNT(*)'];
    }
    public function countMusicBy($where=[]){
        $query = "SELECT COUNT(*) FROM music";

        if (!empty($where)){
            $conditions = [];
            foreach($where as $key => $value){
                if ($value[2] == 'LIKE'){
                    $conditions[] = '$key LIKE :$key';
                } else {
                    $conditions[] = '$key = :$key';
                }
            }
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->db->prepare($query);
        foreach ($where as $key => $value){
            if ($value[2]== 'LIKE'){
                $stmt->bindValue(":$key", "%$value[0]%", $value[1]);
            } else {
                $stmt->bindValue(":$key", $value[0], $value[1]);
            }
        }

        $stmt->execute();

        return $stmt->rowCount();
    }
}