// import './adios';

let currentPage = 1;
let currentSearch = '';
let currentGenre = document.getElementById('filter-by-genre-dropdown').value;
let currentUploadPeriod = document.getElementById('filter-by-date-dropdown').value;
let currentSort = '';
let pageCount = 0;
let suerId = 0;


async function searchMusic(searchValue) {
    updateResults(searchValue, 1, currentGenre, currentUploadPeriod, currentSort);
}

function changePage(page) {
    updateResults(currentSearch, page, currentGenre, currentUploadPeriod, currentSort);
}

function changeGenre(genre) {
    updateResults(currentSearch, 1, genre, currentUploadPeriod, currentSort);
}

function changeUploadPeriod(uploadPeriod) {
    updateResults(currentSearch, 1, currentGenre, uploadPeriod, currentSort);
}

function changeSort(sort) {
    updateResults(currentSearch, 1, currentGenre, currentUploadPeriod, sort);
}

async function updateResults(searchValue, page, genre, uploadPeriod, sort) {
    const adios = new Adios();

    try {
        const params = {};

        const trimmedSearch = searchValue.trim();
        params['search'] = encodeURIComponent(trimmedSearch);
        params['page'] = page;
        params['genre'] = genre;
        params['upload-period'] = uploadPeriod;
        params['sort'] = sort;

        const resp = await adios.get('/api/search', params);
        const data = JSON.parse(resp);
        console.log(data);

        currentSearch = searchValue;
        currentPage = page
        currentGenre = genre;
        currentUploadPeriod = uploadPeriod;
        currentSort = sort;
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
    const elements = await Promise.all(searchResults.map(async ({ music_genre, music_id, music_name, music_owner_name, music_upload_date }) => {
        let coverSrc = '';
        try {
            const coverResp = await adios.get(`/api/music-cover/${music_id}`, {}, true);
            coverSrc = URL.createObjectURL(coverResp);
        } catch (error) {
            coverSrc = "/public/assets/placeholders/music-placeholder.jpg";
        }

        music_upload_date = new Date(music_upload_date).toLocaleDateString(undefined, {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
          });

        return `
                <div class="result-item">
                    <div class="result-info-container">
                        <img class="result-music-cover soft-shadow" src="${coverSrc}">
                        <div class="result-info-text">
                            <div class="result-title">
                                ${music_owner_name}: ${music_name}
                            </div>
                            <div class="result-genre">
                                ${music_genre} - ${music_upload_date}
                            </div>
                        </div>
                    </div>
                    <div class="search-action">
                        <img onclick="addMusicPopup('${music_id}')" class="clickable" src="/public/assets/icons/add.svg">
                        <img onclick="playMusic('${music_id}')" class="play-button clickable" src="/public/assets/media/PlayButton.png">
                    </div>
                </div>
`
    }));

    const divider = '<div class="result-item-divider"></div>';

    document.getElementById('search-page-results').innerHTML = elements.join(divider);
}

async function addMusicPopup(userId, musicId) {
    const adios = new Adios();

    const content = `
        <div class="popup-content-container">
            <select id="collection-type" name="type">
                <option value="playlist">Playlist</option>
                <option value="album">Album</option>
            </select>

            <select name="collection-id" id="collection-id"></select>

            <button onclick="addMusic()">Add Music</button>
        </div>
    `

    titledPopup('Add Music', content);

    let albums = [];
    try {
        const resp = await adios.get('/api/search-album-user', {"userId": userId, "page": 1});
        const data = JSON.parse(resp).data;
        albums = data.result.map(({album_id, album_name}) => ({id: album_id, name: album_name}));
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.log(error);
        }
    }

    let playlists = [];
    try {
        const resp = await adios.get('/api/search-playlist-user', {"userId": userId, "page": 1});
        const data = JSON.parse(resp).data;
        playlists = data.result.map(({playlist_id, playlist_name}) => ({id: playlist_id, name: playlist_name}));
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.log(error);
        }
    }

    const collectionTypeElement = document.getElementById('collection-type');
    const collectionItemsElement = document.getElementById('collection-id');

    collectionTypeElement.addEventListener('change', (e) => {
        const value = e.target.value;
        const collection = (value == 'album' ? albums : playlists);
        let elements = collection.map(({id, name}) => `<option value="${id}">${name}</option>`);
        collectionItemsElement.innerHTML = elements.join(' ');
    })
}

async function addMusic(musicId) {
    try {
        const collectionType = document.getElementById('collection-type').value;
        const collectionId = document.getElementById('collection-id').value;
        const popupElement = document.getElementById('popup-overlay');

        const resp = await adios.post(`/api/${collectionType}/add-music/${collectionId}`, `music_id=${musicId}`);
        console.log(JSON.parse(resp));
        document.body.removeChild(popupElement);
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.log(error);
        }
    }
}

function updatePagination(pageCount) {
    let startNum = Math.max(currentPage - 1, 1);
    let endNum = Math.min(currentPage + 1, pageCount);
    
    if (currentPage == 1)
        endNum = Math.min(currentPage + 2, pageCount)

    if (currentPage == pageCount)
        startNum = Math.max(currentPage - 2, 1);

    const elements = ['<img onclick="changePage(1)" src="/public/assets/icons/double-left.svg" id="pagination-first" class="clickable">'];
    for (let i = startNum - 1; i < endNum; i++) {
        if (i + 1 == currentPage) {
            elements.push(`<div class="pagination-item clickable pagination-active">${i + 1}</div>`);
        } else {
            elements.push(`<div onclick="changePage(${i + 1})" class="pagination-item clickable">${i + 1}</div>`);
        }
    }
    elements.push('<img onclick="changePage(pageCount)" src="/public/assets/icons/double-right.svg" id="pagination-last" class="clickable">');

    document.getElementById('pagination').innerHTML = elements.join(' ');
}

async function initGenre() {
    const adios = new Adios();

    try {
        const resp = await adios.get('/api/genres');
        const data = JSON.parse(resp);
        const genres = data.data.genres;

        const elements = [];

        genres.forEach(genre => {
            elements.push(`<option value="${genre}">${genre.charAt(0).toUpperCase() + genre.slice(1)}</option>`);
        });

        document.getElementById('filter-by-genre-dropdown').innerHTML += ' ' + elements.join(' ');
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.error(error);
        }
    }
}

document
    .getElementById('search-input')
    .addEventListener('keyup', debounce((e) => { searchMusic(e.target.value) }));

document
    .getElementById('filter-by-genre-dropdown')
    .addEventListener('change', (e) => { changeGenre(e.target.value) })

document
    .getElementById('filter-by-date-dropdown')
    .addEventListener('change', (e) => { changeUploadPeriod(e.target.value) })

const sortGenreElement = document.getElementById('sort-by-genre-dropdown')
const sortDateElement = document.getElementById('sort-by-date-dropdown')

sortGenreElement
    .addEventListener('change', (e) => {
        sortDateElement.value = 'unsorted';
        if (e.target.value != 'unsorted') {
            changeSort(`genre-${e.target.value}`);
        } else {
            changeSort('');
        }
    })

sortDateElement
    .addEventListener('change', (e) => {
        sortGenreElement.value = 'unsorted';
        if (e.target.value != 'unsorted') {
            changeSort(`date-${e.target.value}`);
        } else {
            changeSort('');
        }
    })

searchMusic('');
initGenre();