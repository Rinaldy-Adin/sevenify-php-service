<?php

namespace repositories;

require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/playlistModel.php';
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'common/dto/playlistWithArtistNameDTO.php';

use common\dto\PlaylistWithArtistNameDTO;
use Exception;
use DateTime;
use models\MusicModel;
use models\PlaylistModel;
use PDO;


class PlaylistRepository extends Repository {
    private static $instance;
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    public function getAllPlaylists(?int $page) : array {
        $query = "SELECT * FROM playlists";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $playlists = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $playlist = new PlaylistModel($row['playlist_id'], $row['playlist_name'], $row['playlist_owner']);
            $playlists[] = $playlist;
        }

        if ($page) {
            $pageOffset = ($page - 1) * 5;
            return [array_slice($playlists, $pageOffset, 5), ceil(count($playlists) / 5)];
        } else {
            return [$playlist, 0];
        }
    }

    public function getByPlaylistId($playlistId) {
        $query = "SELECT * FROM playlists WHERE playlist_id = :playlist_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":playlist_id", $playlistId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new PlaylistModel($row['playlist_id'], $row['playlist_name'], $row['playlist_owner']);
        } else {
            return null;
        }
    }

    public function getPlaylistMusic($playlistId) : array {
        $query = "SELECT music_id, music_name, music_owner, music_genre, music_upload_date 
                    FROM music 
                    JOIN playlist_music USING (music_id) 
                    WHERE playlist_id = :playlist_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":playlist_id", $playlistId, PDO::PARAM_INT);
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

    public function getCoverPathByPlaylistId(int $playlistId): ?string
    {
        $playlist = $this->getByPlaylistId($playlistId);

        if (!$playlist) {
            return null;
        }

        $files = glob(STORAGE_DIR . "covers/playlist/*");

        if (count($files) > 0)
            foreach ($files as $file) {
                $info = pathinfo($file);
                if ($info['filename'] == strval($playlistId))
                    return realpath($file);
            }

        return null;
    }

    public function createPlaylist(string $playlist_name, int $playlist_owner, ?array $coverFile, array $music_ids): ?PlaylistModel
    {
        $query0 = "INSERT INTO playlists (playlist_name, playlist_owner)
              VALUES (:playlistName, :playlistOwner)";

        $stmt0 = $this->db->prepare($query0);
        $stmt0->bindParam(":playlistName", $playlist_name);
        $stmt0->bindParam(":playlistOwner", $playlist_owner);



        $this->db->beginTransaction();
        try {
            $stmt0->execute();
            $playlistId = (int)$this->db->lastInsertId();

            foreach ($music_ids as $music_id) {
                $query1 = "INSERT INTO playlist_music (music_id, playlist_id)
                    VALUES (:musicId, :playlistId)";

                $stmt1 = $this->db->prepare($query1);
                $stmt1->bindParam(":musicId", $music_id, PDO::PARAM_INT);
                $stmt1->bindParam(":playlistId", $playlistId, PDO::PARAM_INT);
                $stmt1->execute();
            }

            if ($coverFile) {
                $this->saveCoverFile($coverFile, $playlistId);
            }

            $this->db->commit();

            return $this->getByPlaylistId($playlistId);
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Playlist creation error: " . $e->getMessage());
            return null;
        }
    }

    public function deletePlaylist(int $playlistId): bool
    {
        $query0 = "DELETE FROM playlist_music WHERE playlist_id = :playlistId";
        $stmt0 = $this->db->prepare($query0);
        $stmt0->bindParam(":playlistId", $playlistId);

        $query1 = "DELETE FROM playlists WHERE playlist_id = :playlistId";
        $stmt1 = $this->db->prepare($query1);
        $stmt1->bindParam(":playlistId", $playlistId);

        try {
            $stmt0->execute();
            $stmt1->execute();
            $this->deleteCoverFile($playlistId);

            return true;
        } catch (Exception $e) {
            error_log("Music deletion error: " . $e->getMessage());
            return false;
        }
    }

    private function saveCoverFile(array $coverFile, int $playlistId)
    {
        $ext_partition = explode('.', $coverFile['name']);
        $ext = $ext_partition[count($ext_partition) - 1];

        $targetFilePath = STORAGE_DIR . 'covers/playlist/' . $playlistId . '.' . $ext;
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

    private function deleteCoverFile(int $playlistId)
    {
        $path = "covers/playlist/$playlistId.*";
        $file = glob(STORAGE_DIR . $path);

        if (count($file) > 0) {
            $ok = unlink($file[0]);
            if (!$ok) {
                throw new \RuntimeException('Error deleting cover file');
            }
        }
    }

    public function updatePlaylist(int $playlist_id, string $playlist_name, int $playlist_owner, bool $deleteCover, ?array $coverFile, array $music_ids): ?PlaylistModel
    {
        $query0 = "UPDATE playlists
                    SET playlist_name = :playlistName, playlist_owner = :playlistOwner
                    WHERE playlist_id = :playlistId";

        $stmt0 = $this->db->prepare($query0);
        $stmt0->bindParam(":playlistName", $playlist_name);
        $stmt0->bindParam(":playlistOwner", $playlist_owner);
        $stmt0->bindParam(":playlistId", $playlist_id);

        $this->db->beginTransaction();
        try {
            $stmt0->execute();

            $query1 = "DELETE FROM playlist_music WHERE playlist_id = :playlistId";
            $stmt1 = $this->db->prepare($query1);
            $stmt1->bindParam(":playlistId", $playlist_id);
            $stmt1->execute();

            foreach ($music_ids as $music_id) {
                $query2 = "INSERT INTO playlist_music (music_id, playlist_id)
                    VALUES (:musicId, :playlistId)";

                $stmt2 = $this->db->prepare($query2);
                $stmt2->bindParam(":musicId", $music_id, PDO::PARAM_INT);
                $stmt2->bindParam(":playlistId", $playlist_id, PDO::PARAM_INT);
                $stmt2->execute();
            }

            if ($coverFile) {
                $this->saveCoverFile($coverFile, $playlist_id);
            } else {
                if ($deleteCover) {
                    $this->deleteCoverFile($playlist_id);
                }
            }

            $this->db->commit();

            return $this->getByPlaylistId($playlist_id);
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Playlist update error: " . $e->getMessage());
            return null;
        }
    }
    public function getByUserId(int $userId, int $page): array
    {
        $conditions[] = "playlist_owner = :user_id"; 
        $bindings[':user_id'] = $userId;
        
        $query = "SELECT * FROM playlists JOIN users ON user_id = playlist_owner WHERE playlist_owner = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        
        $playlistRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        [$users] = (UserRepository::getInstance()) -> getAllUsers();
        $userIDName = [];

        foreach($users as $user){
            $userIDName[$user->user_id] = $user->user_name;
        }

        $playlistObjects = [];
        foreach ($playlistRecords as $playlistRecord) {
            $playlist = new PlaylistWithArtistNameDTO(
                $playlistRecord['playlist_id'],
                $playlistRecord['playlist_name'],
                $userIDName[$playlistRecord['playlist_owner']],
            );
            $playlistObjects[] = $playlist;
        }

        $pageOffset = ($page - 1) * 4;

        return [array_slice($playlistObjects, $pageOffset, 4), ceil(count($playlistRecords) / 4)];
    }
    public function getByPlaylistIdName(int $playlistId) : array
    {
        $query = "SELECT * FROM playlists JOIN users ON user_id = playlist_owner WHERE playlist_id = :playlist_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":playlist_id", $playlistId, PDO::PARAM_INT);
        $stmt->execute();

        $playlistRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($playlistRecords) {
            [$users] = (UserRepository::getInstance())->getAllUsers();
            $userIDName = [];

            foreach ($users as $user) {
                $userIDName[$user->user_id] = $user->user_name;
            }

            $playlistObjects = [];
            foreach ($playlistRecords as $playlistRecord) {
                $playlist = new PlaylistWithArtistNameDTO(
                    $playlistRecord['playlist_id'],
                    $playlistRecord['playlist_name'],
                    $userIDName[$playlistRecord['playlist_owner']]
                );
                $playlistObjects[] = $playlist;
            }

            return $playlistObjects;
        } else {
            return []; // Playlist not found
        }
    }
}