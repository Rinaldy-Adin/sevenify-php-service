<?php

namespace repositories;
require_once ROOT_DIR . 'repositories/repository.php';

use PDO;

class PlaylistMusicRepository extends Repository {
    public function getMusicIdsByPlaylistId($playlistId) {
        $query = "SELECT music_id FROM playlist_music WHERE playlist_id = :playlist_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":playlist_id", $playlistId, PDO::PARAM_INT);
        $stmt->execute();

        $musicIds = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $musicIds[] = $row['music_id'];
        }

        return $musicIds;
    }

    public function getPlaylistIdsByMusicId($musicId) {
        $query = "SELECT playlist_id FROM playlist_music WHERE music_id = :music_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":music_id", $musicId, PDO::PARAM_INT);
        $stmt->execute();

        $playlistIds = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $playlistIds[] = $row['playlist_id'];
        }

        return $playlistIds;
    }

}