<?php

namespace repositories;
require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/musicModel.php';

use models\MusicModel;
use PDO;

class MusicRepository extends Repository {
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