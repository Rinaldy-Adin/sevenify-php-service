<?php

namespace repositories;

require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/playlistModel.php';

use models\PlaylistModel;
use PDO;


class PlaylistRepository extends Repository {
    public function getAllPlaylists() {
        $query = "SELECT * FROM playlists";
        $stmt = $this->db->query($query);

        $playlists = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $playlist = new PlaylistModel($row['playlist_id'], $row['playlist_name'], $row['playlist_owner'], $row['playlist_cover_path']);
            $playlists[] = $playlist;
        }

        return $playlists;
    }

    public function getPlaylistById($playlistId) {
        $query = "SELECT * FROM playlists WHERE playlist_id = :playlist_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":playlist_id", $playlistId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new PlaylistModel($row['playlist_id'], $row['playlist_name'], $row['playlist_owner'], $row['playlist_cover_path']);
        } else {
            return null; // Playlist not found
        }
    }

}