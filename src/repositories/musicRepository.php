<?php

namespace repositories;

require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';

use common\dto\MusicWithArtistNameDTO;
use Exception;
use models\MusicModel;
use PDO;

class MusicRepository extends Repository
{
    public function getByMusicId(int $musicId): ?MusicModel
    {
        $query = "SELECT * FROM music WHERE music_id = :musicId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":musicId", $musicId);
        $stmt->execute();
        $musicRecord = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($musicRecord) {
            return new MusicModel(
                $musicRecord['music_id'],
                $musicRecord['music_name'],
                $musicRecord['music_owner'],
                $musicRecord['music_genre']
            );
        } else {
            return null;
        }
    }

    public function getAudioPathByMusicId(int $musicId): ?string
    {
        $user = $this->getByMusicId($musicId);

        if (!$user) {
            return null;
        }

        $files = glob(STORAGE_DIR . "music/*");

        if (count($files) > 0)
            foreach ($files as $file) {
                $info = pathinfo($file);
                if ($info['filename'] == strval($musicId))
                    return realpath($file);
            }

        return null;
    }

    public function getCoverPathByMusicId(int $musicId): ?string
    {
        $user = $this->getByMusicId($musicId);

        if (!$user) {
            return null;
        }

        $files = glob(STORAGE_DIR . "covers/music/*");

        if (count($files) > 0)
            foreach ($files as $file) {
                $info = pathinfo($file);
                if ($info['filename'] == strval($musicId))
                    return realpath($file);
            }

        return null;
    }

    public function getByUserId(int $userId): array
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
                $musicRecord['music_genre']
            );
            $musicObjects[] = $music;
        }

        return $musicObjects;
    }

    public function searchMusic(string $searchValue, int $page): array
    {
        // Define dynamic conditions and bindings
        $conditions = [];
        $bindings = [];

        if (trim($searchValue) !== "") {
            $conditions[] = "(music_name LIKE :name_search OR user_name LIKE :uploader_search)";
            $bindings[':name_search'] = "%$searchValue%";
            $bindings[':uploader_search'] = "%$searchValue%";
        }

        $sql = "SELECT * FROM music JOIN users ON user_id = music_owner";

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->db->prepare($sql);
        foreach ($bindings as $placeholder => $value) {
            $stmt->bindParam($placeholder, $value, PDO::PARAM_STR); 
        }

        $stmt->execute();
        $musicRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = (new UserRepository())->getAllUsers();
        $userNameMap = [];

        foreach ($users as $user) {
            $userNameMap[$user->user_id] = $user->user_name;
        }

        $musicObjects = [];
        foreach ($musicRecords as $musicRecord) {
            $music = new MusicWithArtistNameDTO(
                $musicRecord['music_id'],
                $musicRecord['music_name'],
                $userNameMap[$musicRecord['music_owner']],
                $musicRecord['music_genre']
            );
            $musicObjects[] = $music;
        }

        $pageOffset = ($page - 1) * 5;

        return [array_slice($musicObjects, $pageOffset, 5), ceil(count($musicRecords) / 5)];
    }

    public function createMusic(string $music_name, string $music_owner, string $music_genre, array $musicFile, ?array $coverFile): ?MusicModel
    {
        $query = "INSERT INTO music (music_name, music_owner, music_genre)
              VALUES (:musicName, :musicOwner, :musicGenre)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":musicName", $music_name);
        $stmt->bindParam(":musicOwner", $music_owner);
        $stmt->bindParam(":musicGenre", $music_genre);

        $this->db->beginTransaction();
        try {
            $stmt->execute();
            $musicId = $this->db->lastInsertId();

            $this->saveMusicFile($musicFile, $musicId);
            if ($coverFile) {
                $this->saveCoverFile($coverFile, $musicId);
            }

            $this->db->commit();

            return $this->getByMusicId($musicId);
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Music creation error: " . $e->getMessage());
            return null;
        }
    }

    private function saveMusicFile(array $musicFile, int $musicId)
    {
        $ext_partition = explode('.', $musicFile['name']);
        $ext = $ext_partition[count($ext_partition) - 1];
        $ok = move_uploaded_file($musicFile["tmp_name"], STORAGE_DIR . '/music/' . $musicId . '.' . $ext);

        if (!$ok) {
            throw new \RuntimeException('Error saving music file');
        }
    }

    private function saveCoverFile(array $coverFile, int $musicId)
    {
        $ext_partition = explode('.', $coverFile['name']);
        $ext = $ext_partition[count($ext_partition) - 1];
        $ok = move_uploaded_file($coverFile["tmp_name"], STORAGE_DIR . '/covers/music/' . $musicId . '.' . $ext);

        if (!$ok) {
            // echo $coverFile['error'];
            throw new \RuntimeException('Error saving cover file');
        }
    }
}
