async function updateUser(event) {
    event.preventDefault();
    const adios = new Adios();

    try {
        const resp = await adios.post('/api/user', adios.formToXWWWFormUrlencoded(event.target));
        const data = JSON.parse(resp);
        console.log(data);
        window.location.href = '/user-settings';
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.log(error);
        }
    }
}