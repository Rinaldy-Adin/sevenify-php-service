albumCurrentPage = 1;
albumsPerPage = 4;
albumPageCount = 0;
currentAlbum = '';

function displayAlbums(userId) {
    console.log(userId);
    updateAlbumResult(userId, 1);
}

function changeAlbumPage(page) {
    updateAlbumResult(currentAlbum, page);
}

async function updateAlbumResult(userId, page) {
    const adios = new Adios();

    try {
        const params = {};
        params['userId'] = userId;
        params['page'] = page;

        const response = await adios.get('/api/search-album-user', params);
        console.log(response);
        const data = JSON.parse(response);
        console.log("Album ", data);

        currentAlbum = userId;
        albumCurrentPage = page;
        albumPageCount = data.data['page-count'];

        updateAlbumList(adios, data.data.result);
        updatePaginationAlbum(data.data['page-count']);
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.error(error);
        }
    }
}

async function updateAlbumList(adios, searchResults) {
    const elmt = await Promise.all(searchResults.map(async ({ album_id, album_name, album_owner_name }) => {
        let cover = '';
        try {
            const responseCover = await adios.get(`/api/album-cover/${album_id}`, {}, true);
            cover = URL.createObjectURL(responseCover);
            console.log("COVER ALBUM ", cover);
        } catch (error) {
            cover = "public/assets/placeholders/album-placeholder.png"
        }

        return `
            <div class="album-list-item">
                <a href="/album/${album_id}">
                    <img class="album-cover soft-shadow" src="${cover}">
                </a>
                <div class="album-info-text">
                    <div class="album-owner">
                        ${album_owner_name}
                    </div>
                    <div class="album-title">
                        ${album_name}
                    </div>
                </div>
            </div>
        `
    }));
    const divider = '';

    document.getElementById('album-slider').innerHTML = elmt.length > 0 ? elmt.join(divider) : '<h3 class="list-empty-msg">You have no albums</h3>';

}


async function updatePaginationAlbum() {
    let start = Math.max(albumCurrentPage - 1, 1);
    let end = Math.min(albumCurrentPage + 1, albumPageCount);

    if (albumCurrentPage == 1) {
        end = Math.min(albumCurrentPage + 2, albumPageCount);
    }

    if (albumCurrentPage == albumPageCount) {
        start = Math.max(albumCurrentPage - 2, 1);
    }

    const elmt = ['<img class="clickable" onclick="changeAlbumPage(1)" src="/public/assets/icons/double-left.svg" id="pagination-album-first">'];
    for (let i = start - 1; i < end; i++) {
        if (i + 1 == albumCurrentPage) {
            elmt.push(`<div class="pagination-album-item clickable pagination-album-active">${i + 1}</div>`);
        } else {
            elmt.push(`<div onclick="changeAlbumPage(${i + 1})" class="pagination-album-item clickable">${i + 1}</div>`);
        }
    }
    elmt.push('<img onclick="changeAlbumPage(albumPageCount)" src="/public/assets/icons/double-right.svg" id="pagination-album-last" class="clickable">');

    document.getElementById('pagination-album').innerHTML = elmt.join(' ');
}