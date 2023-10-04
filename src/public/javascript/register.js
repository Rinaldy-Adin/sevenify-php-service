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
        console.log(resp);
        const data = JSON.parse(resp);
        console.log(data);
        window.location.href = "/login";
    } catch (error) {
        console.log(error);
        const data = JSON.parse(error.response);
        console.log(data);
    }
}