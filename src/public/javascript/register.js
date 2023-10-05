async function register(event) {
    event.preventDefault();
    const adios = new Adios();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    // TODO: error messages
    const confirmPassword = document.getElementById('confirm-password').value;
    const payload = adios.objectToXWWWFormUrlencoded({username, password});

    try {
        const resp = await adios.post('/api/register', payload);
        const data = JSON.parse(resp);
        window.location.href = "/login";
    } catch (error) {
        const data = JSON.parse(error.response);
    }
}