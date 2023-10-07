let albumCurrentPage = 1;
let albumsPerPage = 4;
let albumPageCount = 0;

function displayAlbums(userId) {
    console.log("CHEECKKKKKKKKKKKK");
    updateResult(userId, 1);
}

function changePage(page) {
    updateResult(currentSearch, page);
}

async function updateResult(userId, page) {
    const adios = new Adios();

    try {
        const params = {};
        params['userId'] = userId;
        params['page'] = page;

        const response = await adios.get('/api/searchAlbumUser', params);
        console.log(response);
        const data = JSON.parse(response);
        console.log("Album ", data);

        currentSearch = userId;
        albumCurrentPage = page;
        albumPageCount = data.data['page-count'];

        updateAlbumList(adios, data.data.result);
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

async function updateAlbumList(adios, searchResults) {
    const elmt = await Promise.all(searchResults.map(async ({ album_id, album_name, album_owner_name }) => {
        let cover = '';
        cover = "/public/assets/placeholders/album-placeholder.png";
        /*
        try {
            const responseCover = await adios.get(`/api/album-cover/'{$album_id}`, {}, true);
            cover = URL.createObjectURL(responseCover);
        } catch (error) {
            cover = "/public/assets/placeholders/album-placeholder.png"
        }
        */

        return `
            <div class="album-list-item">
                <img class="album-cover soft-shadow" src="${cover}">
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
    const divider = '<div class="result-item-divider-album"></div>';

    document.getElementById('album-slider').innerHTML = elmt.join(divider);

}


async function updatePagination() {
    let start = Math.max(albumCurrentPage - 1, 1);
    let end = Math.min(albumCurrentPage + 1, albumPageCount);

    if (albumCurrentPage == 1) {
        end = Math.min(albumCurrentPage + 2, albumPageCount);
    }

    if (albumCurrentPage == albumPageCount) {
        start = Math.max(albumCurrentPage - 2, 1);
    }

    const elmt = ['<img class="clickable" onclick="changePage(1)" src="/public/assets/icons/double-left.svg" id="pagination-album-first">'];
    for (let i = start - 1; i < end; i++) {
        if (i + 1 == albumCurrentPage) {
            elmt.push(`<div class="pagination-album-item clickable pagination-album-active">${i + 1}</div>`);
        } else {
            elmt.push(`<div onclick="changePage(${i + 1})" class="pagination-album-item clickable">${i + 1}</div>`);
        }
    }
    elmt.push('<img onclick="changePage(albumPageCount)" src="/public/assets/icons/double-right.svg" id="pagination-album-last" class="clickable">');

    document.getElementById('pagination-album').innerHTML = elmt.join(' ');
}

displayAlbums(1); //Ganti dengan userID yang login
