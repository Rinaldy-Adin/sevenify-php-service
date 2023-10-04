async function login(event) {
    event.preventDefault();
    const adios = new Adios();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const payload = `username=${username}&password=${password}`;

    try {
        const resp = await adios.post('/api/login', payload);
        console.log(resp);
        const data = JSON.parse(resp);
        console.log(data);
    } catch (error) {
        console.log(error);
        const data = JSON.parse(error.response);
        console.log(data)
    }
}