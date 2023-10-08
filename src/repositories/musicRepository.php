<?php

namespace repositories;

require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/musicModel.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';

use common\dto\MusicWithArtistNameDTO;
use DateTime;
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
            $uploadDate = new DateTime($musicRecord['music_upload_date']);
            return new MusicModel(
                $musicRecord['music_id'],
                $musicRecord['music_name'],
                $musicRecord['music_owner'],
                $musicRecord['music_genre'],
                $uploadDate
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
    public function countAllMusic()
    {
        $query = "SELECT COUNT(*) FROM music";
        $stmt = $this->db->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['COUNT(*)'];
    }
    public function countMusicBy($where = [])
    {
        $query = "SELECT COUNT(*) FROM music";

        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $key => $value) {
                if ($value[2] == 'LIKE') {
                    $conditions[] = '$key LIKE :$key';
                } else {
                    $conditions[] = '$key = :$key';
                }
            }
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->db->prepare($query);
        foreach ($where as $key => $value) {
            if ($value[2] == 'LIKE') {
                $stmt->bindValue(":$key", "%$value[0]%", $value[1]);
            } else {
                $stmt->bindValue(":$key", $value[0], $value[1]);
            }
        }

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function searchMusic(string $searchValue, int $page, string $genre, string $uploadPeriod, string $sort): array
    {
        $conditions = [];
        $bindings = [];

        if (trim($searchValue) !== "") {
            $conditions[] = "(music_name LIKE :name_search OR user_name LIKE :uploader_search)";
            $bindings[':name_search'] = "%$searchValue%";
            $bindings[':uploader_search'] = "%$searchValue%";
        }

        if ($genre != "all") {
            $conditions[] = "music_genre = :genre";
            $bindings[':genre'] = $genre;
        }

        switch ($uploadPeriod) {
            case 'today':
                $conditions[] = "DATE(music_upload_date) = CURDATE()";
                break;
            case 'last-week':
                $conditions[] = "music_upload_date > (CURDATE() - INTERVAL 1 WEEK)";
                break;
            case 'last-month':
                $conditions[] = "music_upload_date > (CURDATE() - INTERVAL 1 MONTH)";
                break;
            case 'last-year':
                $conditions[] = "music_upload_date > (CURDATE() - INTERVAL 1 YEAR)";
                break;
            default:
                break;
        }

        $sql = "SELECT * FROM music JOIN users ON user_id = music_owner";

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        if ($sort !== '' && strpos($sort, "-") !== false) {
            [$sortColumn, $sortMethod] = explode('-', $sort);

            if ($sortColumn == 'date') {
                $sortColumn = 'music_upload_date';
            } else {
                $sortColumn = 'music_genre';
            }

            if ($sortMethod == "ascending") {
                $sortMethod = "ASC";
            } else {
                $sortMethod = "DESC";
            }

            $sql .= " ORDER BY $sortColumn $sortMethod ";
        }

        $stmt = $this->db->prepare($sql);
        foreach ($bindings as $placeholder => $value) {
            $stmt->bindParam($placeholder, $value, PDO::PARAM_STR);
        }

        $stmt->execute();
        $musicRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        [$users] = (new UserRepository())->getAllUsers();
        $userNameMap = [];

        foreach ($users as $user) {
            $userNameMap[$user->user_id] = $user->user_name;
        }

        $musicObjects = [];
        foreach ($musicRecords as $musicRecord) {
            $uploadDate = new DateTime($musicRecord['music_upload_date']);
            $music = new MusicWithArtistNameDTO(
                $musicRecord['music_id'],
                $musicRecord['music_name'],
                $userNameMap[$musicRecord['music_owner']],
                $musicRecord['music_genre'],
                $uploadDate
            );
            $musicObjects[] = $music;
        }

        $pageOffset = ($page - 1) * 5;

        return [array_slice($musicObjects, $pageOffset, 5), ceil(count($musicRecords) / 5)];
    }

    public function getAllGenres(): array
    {
        $query = "SELECT DISTINCT music_genre FROM music";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $genres = [];
        foreach ($records as $key => $record) {
            $genres[] = $record['music_genre'];
        }

        return $genres;
    }

    public function createMusic(string $music_name, string $music_owner, string $music_genre, array $musicFile, ?array $coverFile): ?MusicModel
    {
        $query = "INSERT INTO music (music_name, music_owner, music_genre, music_upload_date)
              VALUES (:musicName, :musicOwner, :musicGenre, :musicUploadDate)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":musicName", $music_name);
        $stmt->bindParam(":musicOwner", $music_owner);
        $stmt->bindParam(":musicGenre", $music_genre);

        $dateStr = date('Y-m-d');
        $stmt->bindParam(":musicUploadDate", $dateStr);

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

        $targetFilePath = STORAGE_DIR . STORAGE_DIR . 'music/' . $musicId . '.' . $ext;
        if (file_exists($targetFilePath)) {
            // Delete the existing file
            unlink($targetFilePath);
        }

        $ok = move_uploaded_file($musicFile["tmp_name"], $targetFilePath);

        if (!$ok) {
            error_log('Error log music: ' . $musicFile['error']);
            throw new \RuntimeException('Error saving music file');
        }
    }

    private function saveCoverFile(array $coverFile, int $musicId)
    {
        $ext_partition = explode('.', $coverFile['name']);
        $ext = $ext_partition[count($ext_partition) - 1];

        $targetFilePath = STORAGE_DIR . 'covers/music/' . $musicId . '.' . $ext;
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

    public function deleteMusic(int $musicId): bool
    {
        $query = "DELETE FROM music WHERE music_id = :musicId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":musicId", $musicId);

        try {
            $stmt->execute();
            $this->deleteMusicFile($musicId);
            $this->deleteCoverFile($musicId);

            return true;
        } catch (Exception $e) {
            error_log("Music deletion error: " . $e->getMessage());
            return false;
        }
    }

    private function deleteMusicFile(int $musicId)
    {
        $file = glob(STORAGE_DIR . "music/$musicId.*");

        if (count($file) > 0) {
            $ok = unlink($file[0]);
            if (!$ok) {
                throw new \RuntimeException('Error deleting music file');
            }
        }
    }

    private function deleteCoverFile(int $musicId)
    {
        $file = glob(STORAGE_DIR . "covers/music/$musicId.*");

        if (count($file) > 0) {
            $ok = unlink($file[0]);
            if (!$ok) {
                throw new \RuntimeException('Error deleting music file');
            }
        }
    }

    public function udpateMusic(int $music_id, string $music_name, string $music_owner, string $music_genre, bool $deleteCover, ?array $coverFile): ?MusicModel
    {
        $query = "UPDATE music 
                    SET music_name = :musicName, music_owner = :musicOwner, music_genre = :musicGenre
                    WHERE music_id = :musicId";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":musicName", $music_name);
        $stmt->bindParam(":musicOwner", $music_owner);
        $stmt->bindParam(":musicGenre", $music_genre);
        $stmt->bindParam(":musicId", $music_id);

        $this->db->beginTransaction();
        try {
            $stmt->execute();

            if ($coverFile) {
                $this->saveCoverFile($coverFile, $music_id);
            } else {
                if ($deleteCover) {
                    $this->deleteCoverFile($music_id);
                }
            }

            $this->db->commit();

            return $this->getByMusicId($music_id);;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Music creation error: " . $e->getMessage());
            return null;
        }
    }
}
