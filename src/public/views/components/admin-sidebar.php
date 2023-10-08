<?php
function renderAdminSidebar(string $currentEntity) {
    $entities = ["music" => "Music", "user" => "User", "album" => "albums", "playlist" => "Playlists"];

    foreach ($entities as $lc => $uc) {
        if ($lc == $currentEntity) {
            echo "<div class=\"current-entity\">$uc</div>";
        } else {
            echo "<a class=\"entity-link\" href=\"/admin/$lc/\">$uc</a>";
        }
    }
}
?>