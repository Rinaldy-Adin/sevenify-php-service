<?php

namespace repositories;

require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/playlistModel.php';
require_once ROOT_DIR . 'common/dto/playlistWithArtistNameDTO.php';

use common\dto\PlaylistWithArtistNameDTO;
use Exception;
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

    public function getByPlaylistId($playlistId) {
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
    public function getByUserId(int $userId, int $page): array
    {
        $conditions[] = "playlist_owner = :user_id"; 
        $bindings[':user_id'] = $userId;
        
        $query = "SELECT * FROM playlists JOIN users ON user_id = playlist_owner WHERE playlist_owner = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        
        $playlistRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = (new UserRepository()) -> getAllUsers();
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

    public function getCoverPathByPlaylistId(int $playlistId): ?string
    {
        $user = $this->getByPlaylistId($playlistId);

        if (!$user) {
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
}