<?php

namespace repositories;


require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/albumModel.php';
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'common/dto/albumWithArtistNameDTO.php';

use common\dto\AlbumWithArtistNameDTO;
use Exception;
use DateTime;
use exceptions\AppException;
use models\AlbumModel;
use models\MusicModel;
use PDO;

class AlbumRepository extends Repository
{
    private static $instance;
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    public function getAllAlbums(?int $page) : array
    {
        $query = "SELECT * FROM albums";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $albums = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $album = new AlbumModel($row['album_id'], $row['album_name'], $row['album_owner']);
            $albums[] = $album;
        }

        if ($page) {
            $pageOffset = ($page - 1) * 5;
            return [array_slice($albums, $pageOffset, 5), ceil(count($albums) / 5)];
        } else {
            return [$albums, 0];
        }
    }

    public function getByAlbumId(int $albumId) : ?AlbumModel {
        $query = "SELECT * FROM albums WHERE album_id = :album_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":album_id", $albumId, PDO::PARAM_INT);
        $stmt->execute();

        $albumRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($albumRecord) {
            return new AlbumModel(
                $albumRecord['album_id'], 
                $albumRecord['album_name'], 
                $albumRecord['album_owner']
            );
        } else {
            return null; // Album not found
        }
    }
    public function getByAlbumIdName(int $albumId) : array
    {
        $query = "SELECT * FROM albums JOIN users ON user_id = album_owner WHERE album_id = :album_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":album_id", $albumId, PDO::PARAM_INT);
        $stmt->execute();

        $albumRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($albumRecords) {
            [$users] = (UserRepository::getInstance())->getAllUsers();
            $userIDName = [];

            foreach ($users as $user) {
                $userIDName[$user->user_id] = $user->user_name;
            }

            $albumObjects = [];
            foreach ($albumRecords as $albumRecord) {
                $album = new AlbumWithArtistNameDTO(
                    $albumRecord['album_id'],
                    $albumRecord['album_name'],
                    $userIDName[$albumRecord['album_owner']],
                    $albumRecord['album_owner']
                );
                $albumObjects[] = $album;
            }

            return $albumObjects;
        } else {
            return []; // Album not found
        }
    }

    public function getByUserId(int $userId, int $page): array
    {
        $query = "SELECT * FROM albums JOIN users ON user_id = album_owner WHERE album_owner = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        
        $albumRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        [$users] = (UserRepository::getInstance())->getAllUsers();
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
                $albumRecord['album_owner']
            );
            $albumObjects[] = $album;
        }

        if ($page > 0) {
            $pageOffset = ($page - 1) * 4;
            return [array_slice($albumObjects, $pageOffset, 4), ceil(count($albumRecords) / 4)];
        } else {
            return [$albumObjects, ceil(count($albumRecords) / 4)];
        }
    }

    public function getCoverPathByAlbumId(int $albumId): ?string
    {
        $album = $this->getByAlbumId($albumId);

        if (!$album) {
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

    public function getAlbumMusic($albumId) : array {
        $query = "SELECT music_id, music_name, music_owner, music_genre, music_upload_date 
                    FROM music 
                    JOIN album_music USING (music_id) 
                    WHERE album_id = :album_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":album_id", $albumId, PDO::PARAM_INT);
        $stmt->execute();
        $musicRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert music records to Music model objects
        $musicObjects = [];
        foreach ($musicRecords as $musicRecord) {
            $uploadDate = new DateTime($musicRecord['music_upload_date']);
            $music = new MusicModel(
                $musicRecord['music_id'],
                $musicRecord['music_name'],
                $musicRecord['music_owner'],
                $musicRecord['music_genre'],
                $uploadDate
            );
            $musicObjects[] = $music;
        }

        return $musicObjects;
    }

    public function createAlbum(string $album_name, int $album_owner, ?array $coverFile, array $music_ids): ?AlbumModel
    {
        $query0 = "INSERT INTO albums (album_name, album_owner)
              VALUES (:albumName, :albumOwner)";

        $stmt0 = $this->db->prepare($query0);
        $stmt0->bindParam(":albumName", $album_name);
        $stmt0->bindParam(":albumOwner", $album_owner);



        $this->db->beginTransaction();
        try {
            $stmt0->execute();
            $albumId = (int)$this->db->lastInsertId();

            foreach ($music_ids as $music_id) {
                $query1 = "INSERT INTO album_music (music_id, album_id)
                    VALUES (:musicId, :albumId)";

                $stmt1 = $this->db->prepare($query1);
                $stmt1->bindParam(":musicId", $music_id, PDO::PARAM_INT);
                $stmt1->bindParam(":albumId", $albumId, PDO::PARAM_INT);
                $stmt1->execute();
            }

            if ($coverFile) {
                $this->saveCoverFile($coverFile, $albumId);
            }

            $this->db->commit();

            return $this->getByAlbumId($albumId);
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Album creation error: " . $e->getMessage());
            throw new AppException();
        }
    }

    public function deleteAlbum(int $albumId): void
    {
        $query0 = "DELETE FROM album_music WHERE album_id = :albumId";
        $stmt0 = $this->db->prepare($query0);
        $stmt0->bindParam(":albumId", $albumId);

        $query1 = "DELETE FROM albums WHERE album_id = :albumId";
        $stmt1 = $this->db->prepare($query1);
        $stmt1->bindParam(":albumId", $albumId);

        try {
            $stmt0->execute();
            $stmt1->execute();
            $this->deleteCoverFile($albumId);
        } catch (Exception $e) {
            error_log("Album deletion error: " . $e->getMessage());
            throw new AppException();
        }
    }

    private function saveCoverFile(array $coverFile, int $albumId)
    {
        $ext_partition = explode('.', $coverFile['name']);
        $ext = $ext_partition[count($ext_partition) - 1];

        $targetFilePath = STORAGE_DIR . 'covers/album/' . $albumId . '.' . $ext;
        if (file_exists($targetFilePath)) {
            // Delete the existing file
            unlink($targetFilePath);
        }

        $ok = move_uploaded_file($coverFile["tmp_name"], $targetFilePath);

        if (!$ok) {
            error_log('Error log cover: ' . $coverFile['error']);
            throw new \RuntimeException('Error saving cover file');
        }
    }

    private function deleteCoverFile(int $albumId)
    {
        $path = "covers/album/$albumId.*";
        $file = glob(STORAGE_DIR . $path);

        if (count($file) > 0) {
            $ok = unlink($file[0]);
            if (!$ok) {
                throw new \RuntimeException('Error deleting album cover file');
            }
        }
    }

    public function updateAlbum(int $album_id, string $album_name, int $album_owner, bool $deleteCover, ?array $coverFile, array $music_ids): ?AlbumModel
    {
        $query0 = "UPDATE albums
                    SET album_name = :albumName, album_owner = :albumOwner
                    WHERE album_id = :albumId";

        $stmt0 = $this->db->prepare($query0);
        $stmt0->bindParam(":albumName", $album_name);
        $stmt0->bindParam(":albumOwner", $album_owner);
        $stmt0->bindParam(":albumId", $album_id);

        $this->db->beginTransaction();
        try {
            $stmt0->execute();

            $query1 = "DELETE FROM album_music WHERE album_id = :albumId";
            $stmt1 = $this->db->prepare($query1);
            $stmt1->bindParam(":albumId", $album_id);
            $stmt1->execute();

            foreach ($music_ids as $music_id) {
                $query2 = "INSERT INTO album_music (music_id, album_id)
                    VALUES (:musicId, :albumId)";

                $stmt2 = $this->db->prepare($query2);
                $stmt2->bindParam(":musicId", $music_id, PDO::PARAM_INT);
                $stmt2->bindParam(":albumId", $album_id, PDO::PARAM_INT);
                $stmt2->execute();
            }

            if ($coverFile) {
                $this->saveCoverFile($coverFile, $album_id);
            } else {
                if ($deleteCover) {
                    $this->deleteCoverFile($album_id);
                }
            }

            $this->db->commit();

            return $this->getByAlbumId($album_id);
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Album update error: " . $e->getMessage());
            throw new AppException();
        }
    }

    function addMusicToAlbum(int $album_id, int $music_id) {
        $query = "INSERT INTO album_music (album_id, music_id)
              VALUES (:album_id, :music_id)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":album_id", $album_id);
        $stmt->bindParam(":music_id", $music_id);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Album music creation error: " . $e->getMessage());
            throw new AppException();
        }
    }
}
