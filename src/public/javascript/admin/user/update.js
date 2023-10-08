async function uploadUser(event, userId) {
    event.preventDefault();
    const adios = new Adios();

    try {
        const resp = await adios.post('/api/admin/user/' + userId, adios.formToXWWWFormUrlencoded(event.target));
        const data = JSON.parse(resp);
        window.location.href = '/admin/user/';
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.log(error);
        }
    }
}