async function updateDataList(adios, searchResults) {
    const elements = await Promise.all(searchResults.map(async (row, idx) => {
        const rowElements = ['<tr>'];

        rowElements.push(`<td>${(currentPage - 1) * 5 + idx + 1}</td>`);

        let coverSrc = '';
        try {
            const coverResp = await adios.get(`/api/playlist-cover/${row['playlist_id']}`, {}, true);
            coverSrc = URL.createObjectURL(coverResp);
        } catch (error) {
            coverSrc = "/public/assets/placeholders/music-placeholder.jpg";
        }
        rowElements.push(`<td lass="table-centered"><img class="soft-shadow" src="${coverSrc}"></td>`);

        for (const key in row) {
            const value = row[key];
            rowElements.push(`<td>${value}</td>`);
        }

        rowElements.push(
            `<td>
                <div class="data-action">
                    <a href="/admin/playlist/update/${row['playlist_id']}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20">
                            <path d="M200-200h56l345-345-56-56-345 345v56Zm572-403L602-771l56-56q23-23 56.5-23t56.5 23l56 56q23 23 24 55.5T829-660l-57 57Zm-58 59L290-120H120v-170l424-424 170 170Zm-141-29-28-28 56 56-28-28Z" />
                        </svg>
                    </a>
                    <div class="clickable" onclick="deleteplaylist(${row['playlist_id']})">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20">
                            <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                        </svg>
                    </div>
                </div>
            </td>`
        );

        rowElements.push(`</tr>`);

        return rowElements.join(' ');
    }));

    document.getElementById('data-page-results').innerHTML = elements.join(' ');
}

async function deletePlaylist(id) {
    const adios = new Adios();

    try {
        const resp = await adios.delete('/api/admin/playlist/' + id);
        const data = JSON.parse(resp);
        console.log(data);

        changePage(currentPage);
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.error(error);
        }
    }
}

function changePage(page) {
    loadDataPage('/api/admin/playlist', page, updateDataList);
}

changePage(currentPage);