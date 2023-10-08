<h2>Your Playlist</h2>
<div class="playlist-slider" id="playlist-slider"></div>
<div id="pagination-playlist"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        displayPlaylists(<?php echo $_SESSION["user_id"]; ?>);
    });
</script>