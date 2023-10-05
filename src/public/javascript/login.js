async function login(event) {
    event.preventDefault();
    const adios = new Adios();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const payload = adios.objectToXWWWFormUrlencoded({username, password});
    
    try {
        const resp = await adios.post('/api/login', payload);
        const data = JSON.parse(resp);
        window.location.href = "/";
    // TODO: Error messages
    } catch (error) {
        const data = JSON.parse(error.response);
    }
}