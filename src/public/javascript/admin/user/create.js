async function uploadUser(event) {
    event.preventDefault();
    const adios = new Adios();

    try {
        await confirmCancelPopup('Create User', "Are you sure you want to create user?");
    } catch (error) {
        return;
    }

    try {
        const resp = await adios.post('/api/admin/user', adios.formToXWWWFormUrlencoded(event.target));
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