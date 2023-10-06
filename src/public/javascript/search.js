// import './adios';

let currentPage = 1;
let currentSearch = '';

async function searchMusic(searchValue) {
    updateResults(searchValue, 1);
}

function changePage(page) {
    updateResults(currentSearch, page);
}

async function updateResults(searchValue, page) {
    const adios = new Adios();

    try {
        const params = {};

        const trimmedSearch = searchValue.trim();
        params['search'] = encodeURIComponent(trimmedSearch);
        params['page'] = page;

        const resp = await adios.get('/api/search', params);
        const data = JSON.parse(resp);

        currentSearch = searchValue;
        currentPage = page
        
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
    const elements = await Promise.all(searchResults.map(async ({ music_genre, music_id, music_name, music_owner_name }) => {
        let coverSrc = '';
        try {
            const coverResp = await adios.get(`/api/music-cover/${music_id}`, {}, true);
            coverSrc = URL.createObjectURL(coverResp);
        } catch (error) {
            coverSrc = "/public/assets/placeholders/music-placeholder.jpg";
        }

        return `
                <div class="result-item">
                    <div class="result-info-container">
                        <img class="result-music-cover soft-shadow" src="${coverSrc}">
                        <div class="result-info-text">
                            <div class="result-title">
                                ${music_owner_name}: ${music_name}
                            </div>
                            <div class="result-genre">
                                ${music_genre}
                            </div>
                        </div>
                    </div>
                    <img onclick="playMusic('${music_id}')" class="play-button clickable" src="/public/assets/media/PlayButton.png">
                </div>
`
    }));

    const divider = '<div class="result-item-divider"></div>';

    document.getElementById('search-page-results').innerHTML = elements.join(divider);
}

function updatePagination(pageCount) {
    const elements = [];
    for (let i = 0; i < pageCount; i++) {
        if (i + 1 == currentPage) {
            elements.push(`<div onclick="changePage(${i+1})" class="pagination-item clickable pagination-active">${i + 1}</div>`);
        } else {
            elements.push(`<div onclick="changePage(${i+1})" class="pagination-item clickable">${i + 1}</div>`);
        }
    }

    document.getElementById('pagination').innerHTML = elements.join(' ');
}

document
    .getElementById('search-input')
    .addEventListener('keyup', debounce((e) => { searchMusic(e.target.value) }));

searchMusic('');