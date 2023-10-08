let currentPlaylistMusicPage = 1;
let currentPlaylistMusicSearch = '';
let pagePMCount = 0;

async function displayPlaylistMusic(playlistId) {
    updateResult(playlistId, 1);
}

function changePage(page) {
    updateResult(currentPlaylistMusicSearch, page);
}

async function updateResult(playlistId, page) {
    const adios = new Adios();

    try {
        const params = {};
        params['playlistId'] = playlistId;
        params['page'] = page;

        const response = await adios.get('/api/search-playlist-music', params);
        const data = JSON.parse(response);
        console.log(data);

        currentPlaylistMusicSearch = playlistId;
        currentPlaylistMusicPage = page;
        pagePMCount = data.data['page-count'];

        updateMusicList(adios, data.data.result);
        updatePagination(data.data['page-count']);
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.error(error);
        }
    }
}

async function updateMusicList(adios, searchResults) {
    const elmt = await Promise.all(searchResults.map(async ({ music_genre, music_id, music_name, music_owner_name, music_upload_date }) => {
        let cover = '';
        try {
            const responseCover = await adios.get(`/api/music-cover/${music_id}`, {}, true);
            cover = URL.createObjectURL(responseCover);
        } catch (error) {
            cover = "/public/assets/placeholders/music-placeholder.jpg";
        }

        music_upload_date - new Date(music_upload_date).toLocaleDateString(undefined, {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        return `
                <div class="playlist-music-list-item">
                    <img onclick="playMusic('${music_id}')" class="play-button clickable" src="/public/assets/media/PlayButton.png">
                    <div class="playlist-music-info-container">
                        <img class="playlist-music-cover soft-shadow" src="${cover}">
                        <div class="playlist-music-info-text">
                            <div class="playlist-music-title">
                                ${music_owner_name}: ${music_name}
                            </div>
                            <div class="playlist-music-genre">
                                ${music_genre} - ${music_upload_date}
                            </div>
                        </div>
                    </div>
                </div>
        `
    }));
    const divider = '<div class="playlist-result-item-divider"></div>';

    document.getElementById('playlist-music-list').innerHTML = elmt.join(divider);
}

function updatePagination(pagePMCount) {
    let start = Math.max(currentPlaylistMusicPage - 1, 1);
    let end = Math.min(currentPlaylistMusicPage + 1, pagePMCount);

    if (currentPlaylistMusicPage == 1) {
        end = Math.min(currentPlaylistMusicPage + 2, pagePMCount);
    }
    if (currentPlaylistMusicPage == pagePMCount) {
        start = Math.max(currentPlaylistMusicPage - 2, 1);
    }

    const elmt = ['<img class="clickable" onclick="changePage(1)" src="/public/assets/icons/double-left.svg" id="pagination-playlist-music-first">'];
    for (let i = start - 1; i < end; i++) {
        if (i + 1 == currentPlaylistMusicPage) {
            elmt.push(`<div class="pagination-playlist-music-item clickable pagination-playlist-music-active">${i + 1}</div>`);
        } else {
            elmt.push(`<div onclick="changePage(${i + 1})" class="pagination-playlist-music-item clickable">${i + 1}</div>`);
        }
    }
    elmt.push('<img onclick="changePage(pagePMCount)" src="/public/assets/icons/double-right.svg" id="pagination-playlist-music-last" class="clickable">');

    document.getElementById('pagination-playlist-music').innerHTML = elmt.join(' ');
}