let albumMusic = [];
const musicListElement = document.getElementById('dynamic-list');

async function uploadAlbum(event) {
    event.preventDefault();
    const adios = new Adios();

    if (event.target.elements['cover-file'].files[0] && !event.target.elements['cover-file'].files[0].type.startsWith('image/')) {
        alert("Must upload an image file")
        return;
    }

    try {
        await confirmCancelPopup('Create Album', "Are you sure you want to create album?");
    } catch (error) {
        return;
    }

    try {
        const resp = await adios.postFormData('/api/create-album', event.target);
        const data = JSON.parse(resp);
        console.log(data);
        window.location.href = '/';
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.log(error);
        }
    }
}

function updateMusicList() {
    const elements = albumMusic.map(({ id, title }) => `
    <li>
        <div class="line-container">
            <div>${id}: ${title}</div>
            <div class="clickable" onclick="deleteListItem(${id})">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                    <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                </svg>
            </div>
        </div>
    </li>
    `);

    musicListElement.innerHTML = elements.join(' ');
}

async function addListItem() {
    const adios = new Adios();
    const addMusicInput = document.getElementById('add-music-input');
    const id = addMusicInput.value.trim();

    try {
        const resp = await adios.get('/api/music/' + id);
        const data = JSON.parse(resp).data;
        albumMusic.push({ id: data.music_id, title: data.music_name });
        addMusicInput.value = '';
        updateMusicList();
    } catch (error) {
        console.error(error);
    }
}

function deleteListItem(id) {
    albumMusic = albumMusic.filter(({ id: listItemId }) => listItemId != id);
    updateMusicList();
}

const image = document.getElementById('cover-image');
const coverInput = document.getElementById('cover-file');

coverInput.addEventListener('change', function () {
    if (coverInput.files.length > 0) {
        const selectedFile = coverInput.files[0];

        if (selectedFile && selectedFile.type.startsWith('image/')) {
            const objectURL = URL.createObjectURL(selectedFile);
            image.src = objectURL;
            // URL.revokeObjectURL(objectURL);
        } else {
            image.src = '/public/assets/placeholders/music-placeholder.jpg';
        }
    }
});