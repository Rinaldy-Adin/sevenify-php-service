currentPage = 1;
currentSearch = '';
pageCount = 0;

async function displayMusic(userId) {
    updateResult(userId, 1);
}

function changePage(page) {
    console.log("Changing page to ", page);
    updateResult(currentSearch, page);
}

async function updateResult(userId, page) {
    const adios = new Adios();

    try {
        const params = {};
        params['userId'] = userId;
        params['page'] = page;

        const response = await adios.get('/api/searchUser', params);
        const data = JSON.parse(response);
        console.log(data);

        currentSearch = userId;
        currentPage = page;
        pageCount = data.data['page-count'];

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
        });;

        return `
                <div class="music-list-item">
                    <img onclick="playMusic('${music_id}')" class="play-button clickable" src="/public/assets/media/PlayButton.png">
                    <div class="music-info-container">
                        <img class="music-cover soft-shadow" src="${cover}">
                        <div class="music-info-text">
                            <div class="music-title">
                                ${music_owner_name}: ${music_name}
                            </div>
                            <div class="music-genre">
                                ${music_genre} - ${music_upload_date}
                            </div>
                        </div>
                    </div>
                    <div class="music-option" onclick="">
                        <img src="/public/assets/media/EditButton.png" alt="Music Option">
                    </div>
                </div>
        `
    }));
    const divider = '<div class="result-item-divider"></div>';

    document.getElementById('music-list').innerHTML = elmt.join(divider);
}

function updatePagination(pageCount) {
    let start = Math.max(currentPage - 1, 1);
    let end = Math.min(currentPage + 1, pageCount);

    if (currentPage == 1) {
        end = Math.min(currentPage + 2, pageCount);
    }
    if (currentPage == pageCount) {
        start = Math.max(currentPage - 2, 1);
    }

    const elmt = ['<img class="clickable" onclick="changePage(1)" src="/public/assets/icons/double-left.svg" id="pagination-first">'];
    for (let i = start - 1; i < end; i++) {
        if (i + 1 == currentPage) {
            elmt.push(`<div class="pagination-item clickable pagination-active">${i + 1}</div>`);
        } else {
            elmt.push(`<div onclick="changePage(${i + 1})" class="pagination-item clickable">${i + 1}</div>`);
        }
    }
    elmt.push('<img onclick="changePage(pageCount)" src="/public/assets/icons/double-right.svg" id="pagination-last" class="clickable">');

    document.getElementById('pagination').innerHTML = elmt.join(' ');
}