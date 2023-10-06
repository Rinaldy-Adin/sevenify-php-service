const audioPlayer = document.getElementById('music-bar-audio-player')
const musicUploader = document.getElementById('music-bar-uploader')
const musicTitle = document.getElementById('music-bar-title')
const musicCover = document.getElementById('music-bar-cover')

async function playMusic(musicId) {
    if (!isNaN(musicId)) {
        musicId = musicId.toString();
    }

    const adios = new Adios();

    try {
        const musicResp = await adios.get(`/api/music/${musicId}`);
        const musicDataFull = JSON.parse(musicResp);
        const musicData = musicDataFull.data;

        musicTitle.textContent = musicData.music_name;

        const userResp = await adios.get(`/api/user/${musicData.music_owner}`);
        const userDataFull = JSON.parse(userResp);
        const userData = userDataFull.data;

        musicUploader.textContent = userData.user_name;

        const coverResp = await adios.get(`/api/music-cover/${musicId}`, {}, true);

        musicCover.src = URL.createObjectURL(coverResp);

        const audioResp = await adios.get(`/api/audio/${musicId}`, {}, true);
        audioPlayer.src = URL.createObjectURL(audioResp);

        audioPlayer.play();
    } catch (error) {
        const data = JSON.parse(error.response);
        alert(data.message);
    }
}

