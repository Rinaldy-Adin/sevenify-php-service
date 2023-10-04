<?php

namespace repositories;
require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/albumModel.php';

use models\AlbumModel;
use PDO;

class AlbumRepository extends Repository {
    public function getAllAlbums() {
        $query = "SELECT * FROM albums";
        $stmt = $this->db->query($query);

        $albums = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $album = new AlbumModel($row['album_id'], $row['album_name'], $row['album_owner'], $row['album_cover_path']);
            $albums[] = $album;
        }

        return $albums;
    }

    public function getAlbumById($albumId) {
        $query = "SELECT * FROM albums WHERE album_id = :album_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":album_id", $albumId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new AlbumModel($row['album_id'], $row['album_name'], $row['album_owner'], $row['album_cover_path']);
        } else {
            return null; // Album not found
        }
    }
}