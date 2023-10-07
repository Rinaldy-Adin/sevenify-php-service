<?php

namespace repositories;

require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/albumModel.php';
require_once ROOT_DIR . 'common/dto/albumWithArtistNameDTO.php';

use common\dto\AlbumWithArtistNameDTO;
use Exception;
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

    public function getByAlbumId(int $albumId) {
        $query = "SELECT * FROM albums WHERE album_id = :album_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":album_id", $albumId, PDO::PARAM_INT);
        $stmt->execute();

        $albumRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($albumRecord) {
            return new AlbumModel(
                $albumRecord['album_id'], 
                $albumRecord['album_name'], 
                $albumRecord['album_owner'], 
                $albumRecord['album_cover_path']);
        } else {
            return null; // Album not found
        }
    }

    public function getByUserId(int $userId, int $page): array
    {
        $conditions[] = "album_owner = :user_id"; 
        $bindings[':user_id'] = $userId;
        
        $query = "SELECT * FROM albums JOIN users ON user_id = album_owner WHERE album_owner = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        
        $albumRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = (new UserRepository()) -> getAllUsers();
        $userIDName = [];

        foreach($users as $user){
            $userIDName[$user->user_id] = $user->user_name;
        }

        $albumObjects = [];
        foreach ($albumRecords as $albumRecord) {
            $album = new AlbumWithArtistNameDTO(
                $albumRecord['album_id'],
                $albumRecord['album_name'],
                $userIDName[$albumRecord['album_owner']],
            );
            $albumObjects[] = $album;
        }

        $pageOffset = ($page - 1) * 4;

        return [array_slice($albumObjects, $pageOffset, 4), ceil(count($albumRecords) / 4)];
    }

    public function getCoverPathBAlbumId(int $albumId): ?string
    {
        $user = $this->getByAlbumId($albumId);

        if (!$user) {
            return null;
        }

        $files = glob(STORAGE_DIR . "covers/album/*");

        if (count($files) > 0)
            foreach ($files as $file) {
                $info = pathinfo($file);
                if ($info['filename'] == strval($albumId))
                    return realpath($file);
            }

        return null;
    }
}