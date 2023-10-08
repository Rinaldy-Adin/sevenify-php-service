<h2>Your Playlist</h2>
    <a href="/create-playlist" class="create-playlist-link">Create Playlist</a>
<div class="playlist-slider" id="playlist-slider"></div>
<div id="pagination-playlist"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        displayPlaylists(<?php echo $_SESSION["user_id"]; ?>);
    });
</script>