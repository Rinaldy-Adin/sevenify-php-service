async function uploadMusic(event) {
    event.preventDefault();
    const adios = new Adios();

    if (!event.target.elements['music-file'].files[0].type.startsWith('audio/')) {
        alert("Must upload an audio file")
        return;
    }

    if (event.target.elements['cover-file'].files[0] && !event.target.elements['cover-file'].files[0].type.startsWith('image/')) {
        alert("Must upload an image file")
        return;
    }

    try {
        const resp = await adios.postFormData('/api/music', event.target);
        const data = JSON.parse(resp);
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