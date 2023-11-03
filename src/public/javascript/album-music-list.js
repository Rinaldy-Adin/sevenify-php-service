let currentAlbumMusicPage = 1;
let currentAlbumMusicSearch = '';
let pageAMCount = 0;

async function displayAlbumMusic(albumId) {
    const adios = new Adios();
    const albumCoverImg = document.getElementById('album-cover-img');
    
    try {
        const responseCover = await adios.get(`/api/album-cover/${albumId}`, {}, true);
        albumCoverImg.src = URL.createObjectURL(responseCover);
    } catch (error) {
        console.log(error);
        albumCoverImg.src = "/public/assets/placeholders/album-placeholder.png";
    }

    updateResult(albumId, 1);
}

function changePage(page) {
    updateResult(currentAlbumMusicSearch, page);
}

async function updateResult(albumId, page) {
    const adios = new Adios();

    try {
        const params = {};
        params['albumId'] = albumId;
        params['page'] = page;

        const response = await adios.get('/api/search-album-music', params);
        const data = JSON.parse(response);
        console.log(data);

        currentAlbumMusicSearch = albumId;
        currentAlbumMusicPage = page;
        pageAMCount = data.data['page-count'];

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

        music_upload_date = new Date(music_upload_date).toLocaleDateString(undefined, {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        return `
                <div class="album-music-list-item">
                    <img onclick="playMusic('${music_id}')" class="play-button clickable" src="/public/assets/media/PlayButton.png">
                    <div class="album-music-info-container">
                        <img class="album-music-cover soft-shadow" src="${cover}">
                        <div class="album-music-info-text">
                            <div class="album-music-title">
                                ${music_owner_name}: ${music_name}
                            </div>
                            <div class="album-music-genre">
                                ${music_genre} - ${music_upload_date}
                            </div>
                        </div>
                    </div>
                </div>
        `
    }));
    const divider = '<div class="album-result-item-divider"></div>';

    document.getElementById('album-music-item').innerHTML = elmt.length > 0 ? elmt.join(divider) : '<h3 class="list-empty-msg">You have no music in your album</h3>';
}

function updatePagination(pageAMCount) {
    let start = Math.max(currentAlbumMusicPage - 1, 1);
    let end = Math.min(currentAlbumMusicPage + 1, pageAMCount);

    if (currentAlbumMusicPage == 1) {
        end = Math.min(currentAlbumMusicPage + 2, pageAMCount);
    }
    if (currentAlbumMusicPage == pageAMCount) {
        start = Math.max(currentAlbumMusicPage - 2, 1);
    }

    const elmt = ['<img class="clickable" onclick="changePage(1)" src="/public/assets/icons/double-left.svg" id="pagination-album-music-first">'];
    for (let i = start - 1; i < end; i++) {
        if (i + 1 == currentAlbumMusicPage) {
            elmt.push(`<div class="pagination-album-music-item clickable pagination-album-music-active">${i + 1}</div>`);
        } else {
            elmt.push(`<div onclick="changePage(${i + 1})" class="pagination-album-music-item clickable">${i + 1}</div>`);
        }
    }
    elmt.push('<img onclick="changePage(pageAMCount)" src="/public/assets/icons/double-right.svg" id="pagination-album-music-last" class="clickable">');

    document.getElementById('pagination-album-music').innerHTML = elmt.join(' ');
}