async function logout() {
    const adios = new Adios();

    try {
        await confirmCancelPopup('Log out', "Are you sure you want to log out of your account?");
    } catch (error) {
        return;
    }

    try {
        const resp = await adios.get('/api/logout');
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