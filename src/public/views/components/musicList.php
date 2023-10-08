<h2>Your Musics</h2>
<div id="music-list"></div>
<div id="pagination"></div>

<script src="/public/javascript/music-list.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        displayMusic(<?php echo $_SESSION["user_id"]; ?>);
    });
</script>