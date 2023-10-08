async function uploadMusic(event, musicId) {
    event.preventDefault();
    const adios = new Adios();

    if (event.target.elements['cover-file'].files[0] && !event.target.elements['cover-file'].files[0].type.startsWith('image/')) {
        alert("Must upload an image file")
        return;
    }

    try {
        const resp = await adios.postFormData('/api/admin/music/' + musicId, event.target);
        console.log(JSON.parse(resp));
        window.location.href = '/admin/music/';
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.log(error);
        }
    }
}

async function initUpdatePage(musicId) {
    const adios = new Adios();

    try {
        const coverResp = await adios.get('/api/music-cover/' + musicId, {}, true);
        image.src = URL.createObjectURL(coverResp);
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.log(error);
        }
    }
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
            // If no file is selected, clear the image's src attribute
            image.src = '/public/assets/placeholders/music-placeholder.jpg';
        }
    }
});