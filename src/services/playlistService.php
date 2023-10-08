<?php

namespace services;

require_once ROOT_DIR . 'models/playlistModel.php';
require_once ROOT_DIR . 'repositories/playlistRepository.php';
require_once ROOT_DIR . 'repositories/userRepository.php';

use models\PlaylistModel;
use repositories\PlaylistRepository;
use repositories\UserRepository;

class PlaylistService
{
    private PlaylistRepository $playlistRepo;

    function __construct()
    {
        $this->playlistRepo = new PlaylistRepository();
    }

    function getByPlaylistId(int $playlistId) : PlaylistModel {
        return $this->playlistRepo->getByPlaylistId($playlistId);
    }

    function getByUserID(int $userId, int $page) : array
    {
        return $this->playlistRepo->getByUserId($userId, $page);
    }

    function getAllPlaylists(?int $page) : array {
        return $this->playlistRepo->getAllPlaylists($page);
    }

    function getPlaylistMusic(int $playlistId) : array {
        return $this->playlistRepo->getPlaylistMusic($playlistId);
    }

    function getCoverPathByPlaylistId(int $playlistId): ?string {
        return $this->playlistRepo->getCoverPathByPlaylistId($playlistId);
    }

    function createPlaylist(string $title, int $user_id, ?array $coverFile, array $music_ids = []) :PlaylistModel {
        return $this->playlistRepo->createPlaylist($title, $user_id, $coverFile, $music_ids);
    }

    function updatePlaylist(int $playlist_id, string $title, int $user_id, bool $deleteCover, ?array $coverFile, array $music_ids) :?PlaylistModel {
        return $this->playlistRepo->updatePlaylist($playlist_id, $title, $user_id, $deleteCover, $coverFile, $music_ids);
    }

    function deletePlaylist(int $playlistId): bool {
        return $this->playlistRepo->deletePlaylist($playlistId);
    }
    function getByPlaylistIdName(int $albumId) : array {
        return $this->playlistRepo->getByPlaylistIdName($albumId);
    }
}