let playlistCurrentPage = 1;
let playlistPerPage = 4;
let playlistPageCount = 0;
let currentPlaylist = '';

function displayPlaylists(userId) {
    updatePlaylistResult(userId, 1);
}

function changePlaylistPage(page) {
    updatePlaylistResult(currentPlaylist, page);
}

async function updatePlaylistResult(userId, page) {
    const adios = new Adios();

    try {
        const params = {};
        params['userId'] = userId;
        params['page'] = page;

        const response = await adios.get('/api/searchPlaylistUser', params);
        const data = JSON.parse(response);

        currentPlaylist = userId;
        playlistCurrentPage = page;
        playlistPageCount = data.data['page-count'];

        updatePlaylistList(adios, data.data.result);
        updatePaginationPlaylist(data.data['page-count']);
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.error(error);
        }
    }
}

async function updatePlaylistList(adios, searchResults) {
    const elmt = await Promise.all(searchResults.map(async ({ playlist_id, playlist_name, playlist_owner_name }) => {
        let cover = '';
        cover = "/public/assets/placeholders/playlist-placeholder.png";
        /*
        try {
            const responseCover = await adios.get(`/api/playlist-cover/'{$playlist_id}`, {}, true);
            cover = URL.createObjectURL(responseCover);
        } catch (error) {
            cover = "/public/assets/placeholders/playlist-placeholder.png"
        }
        */

        return `
            <div class="playlist-list-item" onclick="">
                <img class="playlist-cover soft-shadow" src="${cover}">
                <div class="playlist-info-text">
                    <div class="playlist-owner">
                        ${playlist_owner_name}
                    </div>
                    <div class="playlist-name">
                        ${playlist_name}
                    </div>
                </div>
            </div>
        `;
    }));
    const divider = '<div class="result-item-divider-playlist"></div>';

    document.getElementById('playlist-slider').innerHTML = elmt.join(divider);
}

async function updatePaginationPlaylist() {
    let start = Math.max(playlistCurrentPage - 1, 1);
    let end = Math.min(playlistCurrentPage + 1, playlistPageCount);

    if (playlistCurrentPage == 1) {
        end = Math.min(playlistCurrentPage + 2, playlistPageCount);
    }

    if (playlistCurrentPage == playlistPageCount) {
        start = Math.max(playlistCurrentPage - 2, 1);
    }

    const elmt = ['<img class="clickable" onclick="changePlaylistPage(1)" src="/public/assets/icons/double-left.svg" id="pagination-playlist-first">'];
    for (let i = start - 1; i < end; i++) {
        if (i + 1 == playlistCurrentPage) {
            elmt.push(`<div class="pagination-playlist-item clickable pagination-playlist-active">${i + 1}</div>`);
        } else {
            elmt.push(`<div onclick="changePlaylistPage(${i + 1})" class="pagination-playlist-item clickable">${i + 1}</div>`);
        }
    }
    elmt.push('<img onclick="changePlaylistPage(playlistPageCount)" src="/public/assets/icons/double-right.svg" id="pagination-playlist-last" class="clickable">');

    document.getElementById('pagination-playlist').innerHTML = elmt.join(' ');
}

displayPlaylists(1); //Ganti dengan userID yang login