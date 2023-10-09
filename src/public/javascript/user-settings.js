async function updateUser(event) {
    event.stopPropagation();
    event.preventDefault();
    const adios = new Adios();

    try {
        await confirmCancelPopup('Update User', "Are you sure you want to upate your user profile?");
    } catch (error) {
        return;
    }

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

async function deleteUser() {
    console.log('working delete');
    const adios = new Adios();

    try {
        await confirmCancelPopup('Delete User', "Are you sure you want to delete your account?");
    } catch (error) {
        return;
    }

    try {
        const resp = await adios.delete('/api/user');
        const data = JSON.parse(resp);
        window.location.href = '/login';
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.log(error);
        }
    }
}