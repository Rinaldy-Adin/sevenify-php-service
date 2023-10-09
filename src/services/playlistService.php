<?php

namespace services;

require_once ROOT_DIR . 'models/playlistModel.php';
require_once ROOT_DIR . 'repositories/playlistRepository.php';
require_once ROOT_DIR . 'repositories/userRepository.php';

use exceptions\BadRequestException;
use models\PlaylistModel;
use repositories\PlaylistRepository;

class PlaylistService
{
    private PlaylistRepository $playlistRepo;
    private UserService $userService;

    private static $instance;

    private function __construct()
    {
        $this->userService = UserService::getInstance();
        $this->playlistRepo = PlaylistRepository::getInstance();
    }

    // Static method to get the singleton instance
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    function getByPlaylistId(int $playlistId) : PlaylistModel {
        return $this->playlistRepo->getByPlaylistId($playlistId);
    }

    function getByUserID(int $userId, int $page) : array
    {
        if (!$this->userService->getByUserId($userId))
            throw new BadRequestException("User id does not exist");
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
        if (!$this->getByPlaylistId($playlist_id))
            throw new BadRequestException("Playlist id does not exist");

        return $this->playlistRepo->updatePlaylist($playlist_id, $title, $user_id, $deleteCover, $coverFile, $music_ids);
    }

    function deletePlaylist(int $playlistId): void {
        if (!$this->getByPlaylistId($playlistId))
            throw new BadRequestException("Playlist id does not exist");
        $this->playlistRepo->deletePlaylist($playlistId);
    }
    function getByPlaylistIdName(int $albumId) : array {
        return $this->playlistRepo->getByPlaylistIdName($albumId);
    }
    function addMusicToPlaylist(int $playlist_id, int $music_id) {
        $this->playlistRepo->addMusicToPlaylist($playlist_id, $music_id);
    }
}